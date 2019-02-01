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
            'errors' => '',
            "visibleInfo" => $this->get('session')->get('visibleIfo'),
            "visibleApp" => $this->get('session')->get('visibleApp'),
            "visibleSvg" => $this->get('session')->get('visibleSvg'),
            "visibleRadio" => $this->get('session')->get('visibleRadio'),
        ));  
        }else{
            return $this->redirectToRoute('MD_Accueil');
        }
    
    }
}
