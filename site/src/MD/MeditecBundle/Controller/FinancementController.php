<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class FinancementController extends Controller
{
    public function indexAction(Request $request)
    {
    //-----------------------Variable
     $message = null;   $errors = null;

      return $this->render('MDMeditecBundle:Financement:Financement.html.twig',array(
            'msg' => $message,
            'errors' => $errors,
            "visibleInfo" => $this->get('session')->get('visibleIfo'),
            "visibleApp" => $this->get('session')->get('visibleApp'),
            "visibleSvg" => $this->get('session')->get('visibleSvg'),
            "visibleRadio" => $this->get('session')->get('visibleRadio'),
      ));
    }

}
