<?php

namespace MD\MeditecBundle\Controller;

use MD\MeditecBundle\Entity\Newsletter;
use MD\MeditecBundle\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AccueilController extends Controller
{
    public function indexAction(Request $request)
    {
    //-----------------------Variable
     $message = null;   $errors = null;
    //-----------------------Newsletter 
       //On crée une newsletter
        $newsletter = new Newsletter();

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->create(NewsletterType::class,$newsletter); 

        //Requete en post
        if($request->isMethod('POST')){
            //On fait le lien entre la requete et le formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $formBuilder->handleRequest($request);
            
            $validator = $this->get('validator'); //On recupere le service validator
            $listErrors = $validator->validate($newsletter);

            if($formBuilder->isValid() && count($listErrors) == 0){
                //On test si email existe déjà 
                $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Newsletter');
                $resultat = $repository->myFindOne($newsletter->getMail());

                //On teste si l'adresse mail est correcte
                if($resultat == null){
                 //On enregistre notre objet newsletter dans la bdd
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($newsletter);
                    $em->flush();
                    $message = "Votre inscription a bien été prise en compte.";
                }
                else{
                    $errors = "Vous êtes déjà inscrit à la newsletter!";
                }
            }
            else{
                foreach ($listErrors as $listeError) {
                 $errors = $listeError->getMessage();
                 if($errors <> NULL){
                     break;
                 }
                } 
            }
        }
    //-----------------------Actualité
    $publier = TRUE;
    
    $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Actualite');
    $listeActualite = $repository->findPublieOrderbyOdre($publier);
    
    //-----------------------Partenaire
    $publier = TRUE;
    $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Partenaire');
    $listePartenaire = $repository->findPublieOrderbyOdre($publier);
    
    //-----------------------Chiffres
    $repository = $this->getDoctrine()->getManager()->getRepository('MDMeditecBundle:Chiffre');
    $listeChiffre = $repository->findAllOrderByOrdre();
        
    
    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule

      return $this->render('MDMeditecBundle:Accueil:index.html.twig',array(
            'formNewsletter' => $formBuilder->createView(),
            'msg' => $message,
            'errors' => $errors,
            'lstActualite'=>$listeActualite,
            'lstPartenaire'=>$listePartenaire,
            "listeChiffre" => $listeChiffre,
        ));
    }
    
    
}
