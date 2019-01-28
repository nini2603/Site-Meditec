<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('MDMeditecBundle:Admin:index.html.twig');
        return new Response($content);
    }
    
    public function loginAction()
    {
        $message = "";
        $errors = "";
        return $this->render('MDMeditecBundle:Admin:index.html.twig',array(
            'msg' => $message,
            'errors' => $errors,
        ));
    }
    public function iconeAction()
    {
        return $this->render( 'MDMeditecBundle:Autres:icons.html.twig', array(
            'msg' => '',
            'errors' => '',
        ));
    }
}
