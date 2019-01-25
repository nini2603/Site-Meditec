<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \MD\MeditecBundle\Entity\Partenaire;
use \MD\MeditecBundle\Form\PartenaireType;


class Partenaire_AController extends Controller
{
    public function ajouterAction(Request $request)
    {
        //Variable
        $message = null;
        $errors = null;
        
        $partenaire = new Partenaire();
        $form = $this->get('form.factory')->create(PartenaireType::class, $partenaire);
        
        if($request->isMethod('POST')){
            
            $form->handleRequest($request);
            
            $validator = $this->get('validator');//on recupere le service validator
            $listeErrors = $validator->validate($partenaire);
    
            if($form->isValid() && count($listeErrors) == 0){
                if($partenaire->getFile() != NULL){
                    $partenaire->upload();//On upload le fichier sur le serveur
                    //On enregistre notre objet dans la bdd
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($partenaire);
                    $em->flush();
                    $message = "Le partenaire a été enregistré";
                
                    return $this->redirectToRoute('MD_Admin_Liste_Partenaire'); 
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
        
        return $this->render('MDMeditecBundle:Admin:ajouter_partenaire.html.twig',array(
            "form" => $form->createView(),    
            "msg" => $message,
            "errors" => $errors,
        ));
    }
    
    public function listeAction($message=NULL)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Partenaire');
        $listePartenaire = $repository->findAllOrderByOrdre();
        
        return $this->render('MDMeditecBundle:Admin:liste_partenaire.html.twig',array(
            "message" => $message,
            "lstPartenaire"=>$listePartenaire,
        ));
    }
    
    public function supprimerAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Partenaire');
        $unPartenaire = $repository->findOneBy(array('id'=>$id));
        
        if ($unPartenaire == NULL)
        {
           return $this->redirectToRoute('MD_Admin_Liste_Partenaire'); 
        }
        
        $unPartenaire->removeUpload();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($unPartenaire);
        $em->flush();
        
        $message = "Le partenaire a été supprimée!";
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Partenaire');
        $listePartenaire = $repository->findAllOrderByOrdre();
        
        return $this->render('MDMeditecBundle:Admin:liste_Partenaire.html.twig',array(
            "message" => $message,
            "lstPartenaire"=>$listePartenaire,
        )); 
    }
    
    public function modifierAction($id,Request $request){
        
        //Variable
        $message = null;
        $errors = null;
        
        $repository = $this->getDoctrine()->getManager();
        $unPartenaire = $repository->getRepository('MDMeditecBundle:Partenaire')->findOneBy(array('id'=>$id));
        
        if (!$unPartenaire){
            throw new NotFoundHttpException("Le partenaire avec l'id numero ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create(PartenaireType::class, $unPartenaire);
         
        //Mise a jour de donnée de l'actualité
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');//on recupere le service validator
            $listeErrors = $validator->validate($unPartenaire);
    
            if($form->isValid() && count($listeErrors) == 0){
                
                if( $unPartenaire->getFile() != NULL )
                {
                    $unPartenaire->removeUpload();//On supprime l'ancien fichier
                    $unPartenaire->upload();//On upload le fichier sur le serveur
                }
                
                $repository->flush();//Mise à jour de notre objet dans la bdd
                
                $message = "Le partenaire a été modifié";
                
                return $this->redirectToRoute('MD_Admin_Liste_Partenaire'); 
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
        
        return $this->render('MDMeditecBundle:Admin:modifier_partenaire.html.twig',array(
            "unPartenaire" => $unPartenaire,
            "form" => $form->createView(),    
            "msg" => $message,
            "errors" => $errors,
        ));
    }
}
