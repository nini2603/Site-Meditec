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
          'errors' => ''
      ));
    }
    
    
}
