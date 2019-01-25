<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MD\MeditecBundle\Form\InformatiqueType;
use MD\MeditecBundle\Entity\Informatique;
use Symfony\Component\HttpFoundation\Request;


class Informatique_AController extends Controller
{
    public function indexAction(Request $request)
    {
        //Requete si la page existe
        $em = $this->getDoctrine()->getManager(); 
        $unInfo = $em->getRepository('MDMeditecBundle:Informatique')->findOnlyOne();
                
        if($unInfo){ 
          $id = $unInfo[0]->getId();
          $tabResult= $this->modifier($id,$request);
        }else{
          $tabResult = $this->ajouter($request);
        }
        if($tabResult <> NULL){
            return $this->render('MDMeditecBundle:Admin:informatique.html.twig', $tabResult);
        }else{
            return $this->redirectToRoute('MD_Informatique');
        }
    }
    
    public function ajouter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Variable
        $message = null;$errors = null;$existe=false;
        $update = FALSE;
        
        //instanciation d'informatique
        $info = new Informatique();
         //Creation du formulaire
        $form = $this->get('form.factory')->create(InformatiqueType::class,$info);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');
            $listErrors = $validator->validate($info);
            
            if($form->isValid() && count($listErrors) == 0){

                $info->upload();//On ajoute le fichier
                
                $em->persist($info);
                $em->flush();

                $message ="La page informatique a été enregistré";
                
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
        $info = $em->getRepository('MDMeditecBundle:Informatique')->findOneBy(array('id'=>$id));

        //Creation du formulaire
        $form = $this->get('form.factory')->create(InformatiqueType::class,$info);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            $validator = $this->get('validator');
            $listErrors = $validator->validate($info);
            
            if($form->isValid() && count($listErrors) == 0){
                
                if($info->getFile() != NULL){
                    $info->removeUpload();//On supprime l'ancien fichier si il existe
                    $info->upload();//On ajoute le fichier
                } 
                
                $em->flush();// Mise a jour des données dans la base

                $message ="La page informatique a été enregistré";
                
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
