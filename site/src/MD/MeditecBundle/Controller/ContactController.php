<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ContactController extends Controller
{
    public function indexAction()
    {


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule

      return $this->render('MDMeditecBundle:Contact:contact.html.twig', array(
          'msg' => '',
          'errors' => '',
          "visibleInfo" => $this->get('session')->get('visibleIfo'),
          "visibleApp" => $this->get('session')->get('visibleApp'),
          "visibleSvg" => $this->get('session')->get('visibleSvg'),
          "visibleRadio" => $this->get('session')->get('visibleRadio'),
      ));
    }
    
    
}
