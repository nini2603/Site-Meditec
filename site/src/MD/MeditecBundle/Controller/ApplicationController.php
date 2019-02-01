<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ApplicationController extends Controller
{
    public function indexAction()
    {
    
        //Requete si la page existe
        $em = $this->getDoctrine()->getManager(); 
        $uneAppli = $em->getRepository('MDMeditecBundle:Application')->findOnlyOne();
        
        $listeProduits = $em->getRepository('MDMeditecBundle:Application_Produit')->findAll();
        
        
        if($uneAppli){
        return $this->render('MDMeditecBundle:Application:application.html.twig', array(
            'listeProduits'=>$listeProduits,
            'pageAppli'=>$uneAppli[0],
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
