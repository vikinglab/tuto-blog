<?php

namespace T\MainBundle\Controller;

use T\MainBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TMainBundle:Default:index.html.twig', array());
    }

    public function tarifAction()
    {
        return $this->render('TMainBundle:Default:tarif.html.twig', array());
    }

    public function contactAction(Request $r)
    {

        // on créer le formulaire à partir de notre formType
        $formContact = $this->createForm(new ContactType());

        // on vérifi si c'est une méthode post
        if ($r->isMethod('post')) {
            // on récupére les informations du formulaire soumis et on set les différents champs de notre formulaire avec.
            $formContact->handleRequest($r);

            //on vérifie si le formulaire est valide, souvenez vous des différents validateurs que nous avons mis en place sur notre entitée contact
            if ($formContact->isValid()) {

                // Ici on récupére la class Contact qui a été préalablement Set avec les champs du formulaire
                $contact = $formContact->getData();

                $message = \Swift_Message::newInstance()
                    ->setSubject($contact->getSujet())
                    ->setFrom($contact->getEmail())
                    // notre adresse mail
                    ->setTo('contact@viking-lab.fr')
                    ->setContentType('text/html')
                    //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                    ->setBody(
                            $this->renderView('TMainBundle:Contact:email.html.twig', array(
                                'contact' => $contact,
                            )
                        )
                    )
                ;

                // nous appelons le service swiftmailer et on envoi :)
                $this->get('mailer')->send($message);

                // on retourne une message flash pour l'utilisateur pour le prévenir que son mail est bien parti
                $this->get('session')->getFlashBag()->add('success', 'Merci pour votre email !');
            } else {
                //si le formulaire n'est pas valide en plus des erreurs du form
                $this->get('session')->getFlashBag()->add('danger', 'Désolé un problème est survenu.');
            }
        }

        return $this->render('TMainBundle:Contact:contact.html.twig', array(
            // on renvoi dans la vue "la vue" du formulaire
            'formContact' => $formContact->createView(),
        ));
    }
}
