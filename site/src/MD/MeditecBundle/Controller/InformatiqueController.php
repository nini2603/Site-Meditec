<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class InformatiqueController extends Controller
{
    public function indexAction()
    {
    
    //Requete si la page existe
    $em = $this->getDoctrine()->getManager(); 
    $unInfo = $em->getRepository('MDMeditecBundle:Informatique')->findOnlyOne();
    
    if($unInfo){
    return $this->render('MDMeditecBundle:Informatique:informatique.html.twig', array(
        'pageInfo'=>$unInfo[0],
        'msg' => '',
        'errors' => ''
    ));  
    }else{
        return $this->redirectToRoute('MD_Informatique');
    }
    
    }
}
