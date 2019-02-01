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
        'errors' => '',
        "visibleInfo" => $this->get('session')->get('visibleIfo'),
        "visibleApp" => $this->get('session')->get('visibleApp'),
        "visibleSvg" => $this->get('session')->get('visibleSvg'),
        "visibleRadio" => $this->get('session')->get('visibleRadio'),
    ));  
    }else{
        return $this->redirectToRoute('MD_Informatique');
    }
    
    }

    public function visible()
    {
        $em = $this->getDoctrine()->getManager();
        $unInfo = $em->getRepository('MDMeditecBundle:Informatique')->findOnlyOne();

        return $unInfo[0].getVisible();
    }

}
