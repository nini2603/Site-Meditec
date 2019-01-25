<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MD\MeditecBundle\Form\ApplicationType;
use MD\MeditecBundle\Entity\Application;
use Symfony\Component\HttpFoundation\Request;
use MD\MeditecBundle\Entity\Application_Produit;
use MD\MeditecBundle\Form\Application_ProduitType;

class Application_AController extends Controller
{
    public function indexAction(Request $request)
    {
        //Requete si la page existe
        $em = $this->getDoctrine()->getManager(); 
        $uneAppli = $em->getRepository('MDMeditecBundle:Application')->findOnlyOne();
        
        if($uneAppli){ 
          $id = $uneAppli[0]->getId();
          $tabResult= $this->modifier($id,$request);
        }else{
          $tabResult = $this->ajouter($request);
        }
        if($tabResult <> NULL){
            return $this->render('MDMeditecBundle:Admin:Application.html.twig', $tabResult);
        }else{
            return $this->redirectToRoute('MD_Application');
        }
    }
    
    public function ajouter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Variable
        $message = null;$errors = null;$existe=false;
        $update = FALSE;
        
        //instanciation d'informatique
        $appli = new Application();
         //Creation du formulaire
        $form = $this->get('form.factory')->create(ApplicationType::class,$appli);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');
            $listErrors = $validator->validate($appli);
            
            if($form->isValid() && count($listErrors) == 0){

                $appli->upload();//On ajoute le fichier
                
                $em->persist($appli);
                $em->flush();

                $message ="La page application a été enregistré";
                
                return NULL;
            }
            else
            {
                foreach ($listErrors as $oneError){
                    $errors = $oneError->getMessage();
                    if($errors <> NULL){
                        break;
                    } 
                }
            }
            
        }             
        return array('form' => $form->createView(),'msg' => $message,'errors' => $errors);
    }
    
    public function modifier($id,Request $request){
         //Variable
        $message = null;$errors = null;$existe=false;
        $update = FALSE;
        
        //Requete si la page existe
        $em = $this->getDoctrine()->getManager(); 
        $appli = $em->getRepository('MDMeditecBundle:Application')->findOneBy(array('id'=>$id));

        //Creation du formulaire
        $form = $this->get('form.factory')->create(ApplicationType::class,$appli);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');
            $listErrors = $validator->validate($appli);
            
            if($form->isValid() && count($listErrors) == 0){
                
                if($appli->getFile() != NULL){
                    $appli->removeUpload();//On supprime l'ancien fichier si il existe
                    $appli->upload();//On ajoute le fichier
                } 
                
                $em->flush();// Mise a jour des données dans la base

                $message ="La page application a été enregistré";
                
                return NULL;
            }
            else
            {
                foreach ($listErrors as $oneError){
                    $errors = $oneError->getMessage();
                    if($errors <> NULL){
                        break;
                    }
                }
            }
            
        }             
        
      return array('form' => $form->createView(),'msg' => $message,'errors' => $errors);
    }
    
    //------------------------------------ function pour les produits radiologies
    
    public function produit_ajouterAction(Request $request)
    { 
        //variables
        $message = NULL; $errors = NULL;
        
        $em = $this->getDoctrine()->getManager();
        
        $unProduit = new Application_Produit();//Instanciation d'un produit
        
        $form = $this->get('form.factory')->create(Application_ProduitType::class,$unProduit);
        
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $validator = $this->get('validator');
            $listErrors = $validator->validate($unProduit);
            
            if($form->isValid() && count($listErrors) == 0)
            {
                $unProduit->upload();
                $em->persist($unProduit);
                $em->flush();
                
                $message = "Le produit a été ajouté!";                
                
                return $this->redirectToRoute('MD_Admin_Application_Liste_Produit');
                
            }else
            {
                foreach ($listErrors as $oneError){
                    $errors = $oneError->getMessage();
                    if($errors <> NULL){
                        break;
                    }
                }
            }
            
        }    

            return $this->render('MDMeditecBundle:Admin:Application_produit.html.twig', array(
                'titre'=>'Ajouter un produit',
                'msg'=>$message,
                'errors'=>$errors,
                'form'=>$form->createView()
            ));
        
    }
   public function liste_ProduitAction()
   {
    $message = NULL; $errors=NULL;
    
    $em = $this->getDoctrine()->getManager();
    $listeProduit = $em->getRepository('MDMeditecBundle:Application_Produit')->findAll();
    
    if ($listeProduit == NULL){
        $errors = "La liste des produits est vide";
    }
    
    return $this->render('MDMeditecBundle:Admin:liste_Application_produit.html.twig',array(
        'msg'=>$message,
        'errors'=>$errors,
        'listeProduit'=>$listeProduit
    ));
   }
   
   public function supprimer_produitAction($id)
   {
       $message = NULL;$errors = NULL;
       $em = $this->getDoctrine()->getManager();
       $repository = $em->getRepository('MDMeditecBundle:Application_Produit');
       $unProduit = $repository->findOneBy(array('id'=>$id));
       
       if ($unProduit)
       {
           $unProduit->removeUpload();
           $em->remove($unProduit);
           $em->flush();
           $message = "Le produit a été supprimé!";
       }else
       {
           $errors = "Une erreur est survenue, merci de réessayer plus tard.";
       }
       
        $listeProduit = $em->getRepository('MDMeditecBundle:Application_Produit')->findAll();

        if (count($listeProduit) == 0){
            $message = "La liste des produits est vide";
        }

        return $this->render('MDMeditecBundle:Admin:liste_Application_produit.html.twig',array(
            'msg'=>$message,
            'errors'=>$errors,
            'listeProduit'=>$listeProduit
        ));
   }
   public function modifier_ProduitAction($id,request $request)
   {
       $message = NULL;$errors = NULL;
       
       //recherche du produits
       $em = $this->getDoctrine()->getManager();
       $unProduit = $em->getRepository('MDMeditecBundle:Application_Produit')->findOneBy(array('id'=>$id));
       
       if ($unProduit == NULL){
          return $this->redirectToRoute('MD_Admin_Application_Liste_Produit');
       }
       
      //Creation du formulaire
      $form = $this->get('form.factory')->create(Application_ProduitType::class,$unProduit);
      
      if($request->isMethod('POST'))
      {
        $form->handleRequest($request);
          
          $validator = $this->get('validator');
          $listeErrors = $validator->validate($unProduit);
          
          if($form->isValid() && count($listeErrors) == 0){
              if($unProduit->getFile()!= NULL ){
                  $unProduit->removeUpload();
                  $unProduit->upload();
              }
              
              $em->flush();//Mise a jour des données 
              $message = "Le produit a été mise a jour!";
              
              return $this->redirectToRoute('MD_Admin_Application_Liste_Produit');//Redirige vers liste produit
              
          }else{
              foreach ($listeErrors as $listeError) {
                 $errors = $listeError->getMessage();
                 if($errors <> NULL){
                     break;
                 }
                } 
          }
      }
    
    return $this->render('MDMeditecBundle:Admin:Application_produit.html.twig', array(
        'titre'=>'Modifier produit',
        'msg'=>$message,
        'errors'=>$errors,
        'form'=>$form->createView()
    ));
   }
}
