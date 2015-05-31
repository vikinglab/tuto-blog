<?php

namespace T\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() // ici on supprime "name"
    {
        return $this->render('TMainBundle:Default:index.html.twig', array()); // ici on renvoi rien a notre vue
    }
}
