<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class RadiologieController extends Controller
{
    public function indexAction()
    {
    
        //Requete si la page existe
        $em = $this->getDoctrine()->getManager(); 
        $uneRadio = $em->getRepository('MDMeditecBundle:Radiologie')->findOnlyOne();
        
        $listeProduits = $em->getRepository('MDMeditecBundle:Radiologie_Produit')->findAll();
        
        
        if($uneRadio){
        return $this->render('MDMeditecBundle:Radiologie:radiologie.html.twig', array(
            'listeProduits'=>$listeProduits,
            'pageRadio'=>$uneRadio[0],
            'msg' => '',
            'errors' => ''
        ));  
        }else{
            return $this->redirectToRoute('MD_Accueil');
        }
    
    }
}
