<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MD\MeditecBundle\Form\SauvegardeType;
use MD\MeditecBundle\Entity\Sauvegarde;
use Symfony\Component\HttpFoundation\Request;

class Sauvegarde_AController extends Controller
{
    public function indexAction(Request $request)
    {
        //Requete si la page existe
        $em = $this->getDoctrine()->getManager(); 
        $uneSvg = $em->getRepository('MDMeditecBundle:Sauvegarde')->findOnlyOne();
                
        if($uneSvg){ 
          $id = $uneSvg[0]->getId();
          $tabResult= $this->modifier($id,$request);
        }else{
          $tabResult = $this->ajouter($request);
        }
        if($tabResult <> NULL){
            return $this->render('MDMeditecBundle:Admin:sauvegarde.html.twig', $tabResult);
        }else{
            return $this->redirectToRoute('MD_Sauvegarde');
        }
    }
    
    public function ajouter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Variable
        $message = null;$errors = null;$existe=false;
        $update = FALSE;
        
        //instanciation d'informatique
        $svg = new Sauvegarde();
         //Creation du formulaire
        $form = $this->get('form.factory')->create(SauvegardeType::class,$svg);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');
            $listErrors = $validator->validate($svg);
            
            if($form->isValid() && count($listErrors) == 0){

                $svg->upload();//On ajoute le fichier
                
                $em->persist($svg);
                $em->flush();

                $message ="La page sauvegarde a été enregistré";
                
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
        $svg = $em->getRepository('MDMeditecBundle:Sauvegarde')->findOneBy(array('id'=>$id));

        //Creation du formulaire
        $form = $this->get('form.factory')->create(SauvegardeType::class,$svg);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');
            $listErrors = $validator->validate($svg);
            
            if($form->isValid() && count($listErrors) == 0){
                
                if($svg->getFile() != NULL){
                    $svg->removeUpload();//On supprime l'ancien fichier si il existe
                    $svg->upload();//On ajoute le fichier
                } 
                
                $em->flush();// Mise a jour des données dans la base

                $message ="La page sauvegarde a été enregistré";
                
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
}
