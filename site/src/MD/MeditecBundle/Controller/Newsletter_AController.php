<?php

namespace MD\MeditecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \MD\MeditecBundle\Entity\Newsletter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Newsletter_AController extends Controller
{ 
    public function listeAction($message=NULL)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Newsletter');
        $listeNewsletter = $repository->findAll();
        
        return $this->render('MDMeditecBundle:Admin:liste_newsletter.html.twig',array(
            "message" => $message,
            "listeNewsletter"=>$listeNewsletter,
        ));
    }
    
    public function csvAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Newsletter');
        $listeNewsletter = $repository->findAll();
        
       $response = new StreamedResponse();
      $response->setCallback(function() use ($listeNewsletter) {
        $handle = fopen('php://output', 'w+');

        fputcsv($handle, ['Id', 'E-mail'], ';');

        foreach ($listeNewsletter as $news) {
            fputcsv(
                $handle,
                [$news->getId(), $news->getMail()],
                ';'
             );
        }

        fclose($handle);
    });

    $response->setStatusCode(200);
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

    return $response;
    }
}