<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \MD\MeditecBundle\Entity\Chiffre;
use \MD\MeditecBundle\Form\ChiffreType;

class Chiffre_AController extends Controller
{
    public function ajouterAction(Request $request)
    {
        //Variables
        $message = NULL;
        $errors = NULL;
        
        //Creation du formulaire
        
        $unChiffre = new Chiffre();
        
        $form = $this->get('form.factory')->create(ChiffreType::class ,$unChiffre );
        
        //Mise a jour des données chiffre
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            
            $validator = $this->get('validator');//Onrecupere le service validator
            $listeErrors = $validator->validate($unChiffre);
            
            if($form->isValid() && count($listeErrors) == 0 )
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($unChiffre);
                $em->flush();
                $message = "Le chiffre a été ajouté";
                
            }else{
                foreach ($listeErrors as $listeError) {
                 $errors = $listeError->getMessage();
                 if($errors <> NULL){
                     break;
                 }
                }
            } 
        }
        
        return $this->render('MDMeditecBundle:Admin:ajouter_chiffre.html.twig',array(    
            "msg" => $message,
            "errors" => $errors,
            "form" => $form->createView(),
        ));
    }
    
    public function listeAction()
    {
        $message = "";
        $errors = "";
        
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Chiffre');
        $listeChiffre = $repository->findAllOrderByOrdre();
        
        return $this->render('MDMeditecBundle:Admin:liste_chiffre.html.twig',array( 
            "message" => $message,
            "errors" => $errors,
            "listeChiffre" => $listeChiffre,
        ));
    } 
    
     public function supprimerAction($id)
    {
        $message = "";
        $errors = ""; 
         
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Chiffre');
        $unChiffre = $repository->findOneBy(array('id'=>$id));
        
        if ($unChiffre == NULL)
        {
           return $this->redirectToRoute('MD_Admin_Liste_Chiffre'); 
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($unChiffre);
        $em->flush();
        
        $message = "Le chiffre a été supprimée!";
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Chiffre');
        $listeChiffre = $repository->findAllOrderByOrdre();
        
        return $this->render('MDMeditecBundle:Admin:liste_chiffre.html.twig',array(
            "message" => $message,
            "listeChiffre" => $listeChiffre,
        )); 
    }
    
    public function modifierAction($id,Request $request)
    {
        //Variable
        $message = null;
        $errors = null;
        
        $repository = $this->getDoctrine()->getManager();
        $unChiffre = $repository->getRepository('MDMeditecBundle:Chiffre')->findOneBy(array('id'=>$id));
        
        if (!$unChiffre){
            throw new NotFoundHttpException("L'actualité avec l'id numero ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create(ChiffreType::class, $unChiffre);
         
        //Mise a jour de donnée du chiffre
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');//on recupere le service validator
            $listeErrors = $validator->validate($unChiffre);
    
            if($form->isValid() && count($listeErrors) == 0){
               
                $repository->flush();//Mise à jour de notre objet dans la bdd
                
                $message = "Le chiffre a été modifié";
                
                return $this->redirectToRoute('MD_Admin_Liste_Chiffre'); 
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
        
        return $this->render('MDMeditecBundle:Admin:modifier_Chiffre.html.twig',array(
            "unChiffre" => $unChiffre,
            "form" => $form->createView(),    
            "msg" => $message,
            "errors" => $errors,
        ));
    }
    
}

   