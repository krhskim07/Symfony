<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
     /**
    * @Route("/accueil")
    *
    * www.monblog.com/accueil
    * localhost:8000/accueil
    */
    public function accueil(){
        echo 'Hello world !';
    }


    /**
    * @Route("/bonjour", name="bonjour")
    *
    * localhost:8000/bonjour
    */
    public function bonjour(){
        return new Response('<h1>Bonjour tout le monde</h1>');
    }
    
    /**
    * @Route("/hola/{prenom}")
    *
    */
    public function hola($prenom){

        return $this -> render('test/hola.html.twig', array(
            'prenom' => $prenom
        ));

        // La fonction nous permet d'afficher une vue. Elle pointe vers le dossier Templates/
    }



    /**
    * @Route("/redirect")
    *
    */
    public function redirect2(){
        return $this -> redirectToRoute('bonjour');
    }
    // test : localhost:8000/redirect ---> bonjour


    /**
    * @Route("/message", name="message")
    */
    public function message(){
        $this -> addFlash('success', 'Félicitations, vous êtes inscrit');
        $this -> addFlash('errors', 'L\'article 2 a bien été supprimé !');

        return $this -> render('test/message.html.twig');
    }

    
}
