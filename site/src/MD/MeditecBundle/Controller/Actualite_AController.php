<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \MD\MeditecBundle\Entity\Actualite;
use \MD\MeditecBundle\Form\ActualiteType;


class Actualite_AController extends Controller
{
    public function ajouterAction(Request $request)
    {
        //Variable
        $message = null;
        $errors = null;
        
        $actualite = new Actualite();
        $form = $this->get('form.factory')->create(ActualiteType::class, $actualite);
        
        if($request->isMethod('POST')){
            
            $form->handleRequest($request);
            
            $validator = $this->get('validator');//on recupere le service validator
            $listeErrors = $validator->validate($actualite);
    
            if($form->isValid() && count($listeErrors) == 0){
                if($actualite->getFile() != NULL){
                    $actualite->upload();//On upload le fichier sur le serveur
                    //On enregistre notre objet dans la bdd
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($actualite);
                    $em->flush();
                    $message = "L'actualité a été enregistré";
                
                    return $this->redirectToRoute('MD_Admin_Liste_Actualite'); 
                }else{
                    $errors = "Vous devez selectioner une image!";
                }
            }else
            {
                foreach ($listeErrors as $listeError) {
                 $errors = $listeError->getMessage();
                 if($errors <> NULL){
                     break;
                 }
                } 
            }
        }
        
        return $this->render('MDMeditecBundle:Admin:ajouter_actualite.html.twig',array(
            "form" => $form->createView(),    
            "msg" => $message,
            "errors" => $errors,
        ));
    }
    
    public function listeAction($message=NULL)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Actualite');
        $listeActualite = $repository->findAllOrderByOrdre();
        
        return $this->render('MDMeditecBundle:Admin:liste_actualite.html.twig',array(
            "message" => $message,
            "lstActualite"=>$listeActualite,
        ));
    }
    
    public function supprimerAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Actualite');
        $uneActualite = $repository->findOneBy(array('id'=>$id));
        
        if ($uneActualite == NULL)
        {
           return $this->redirectToRoute('MD_Admin_Liste_Actualite'); 
        }
        
        $uneActualite->removeUpload();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($uneActualite);
        $em->flush();
        
        $message = "L'actualié a été supprimée!";
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Actualite');
        $listeActualite = $repository->findAllOrderByOrdre();
        
        return $this->render('MDMeditecBundle:Admin:liste_actualite.html.twig',array(
            "message" => $message,
            "lstActualite"=>$listeActualite,
        )); 
    }
    
    public function modifierAction($id,Request $request){
        
        //Variable
        $message = null;
        $errors = null;
        
        $repository = $this->getDoctrine()->getManager();
        $uneActualite = $repository->getRepository('MDMeditecBundle:Actualite')->findOneBy(array('id'=>$id));
        
        if (!$uneActualite){
            throw new NotFoundHttpException("L'actualité avec l'id numero ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create(ActualiteType::class, $uneActualite);
         
        //Mise a jour de donnée de l'actualité
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');//on recupere le service validator
            $listeErrors = $validator->validate($uneActualite);
    
            if($form->isValid() && count($listeErrors) == 0){
                
                if( $uneActualite->getFile() != NULL )
                {
                    $uneActualite->removeUpload();//On supprime l'ancien fichier
                    $uneActualite->upload();//On upload le fichier sur le serveur
                }
                
                $repository->flush();//Mise à jour de notre objet dans la bdd
                
                $message = "L'actualité a été modifié";
                
                return $this->redirectToRoute('MD_Admin_Liste_Actualite'); 
            }else
            {
                foreach ($listeErrors as $listeError) {
                 $errors = $listeError->getMessage();
                 if($errors <> NULL){
                     break;
                 }
                } 
            }
            
        }
        
        return $this->render('MDMeditecBundle:Admin:modifier_actualite.html.twig',array(
            "uneActualite" => $uneActualite,
            "form" => $form->createView(),    
            "msg" => $message,
            "errors" => $errors,
        ));
    }
}
