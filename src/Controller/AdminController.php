<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class AdminController extends AbstractController
{
 
    //CRUD POST

/**
 * 
 * @Route("/admin/post", name="admin_post")
 */

 public function adminPost() {

 }

/**
 * 
 * @Route("/admin/post/add", name="admin_post_add")
 */

public function adminPostAdd(){


    $post = new Post; // objet vide
    
    $post
        -> setTitle('Neymar blessé')
        -> setContent('Lorem ipsum')
        -> setDatePosted(new \DateTime('now'))
        -> setImage('neymar.jpg')
        -> setCategory('sport');

    $manager = $this -> getDoctrine() -> getManager();
    $manager -> persist($post); // enregistre notre post dans le systeme
    $post -> setImage('neymar.jpg');
    $manager -> flush();

    return $this -> redirectToRoute('home');
    // test : localhost:8000/admin/post/add
}

/**
 * 
 * @Route("/admin/post/update/{id}", name="admin_post_update")
 */

public function adminPostUpdate($id){

    
}

/**
 * 
 * @Route("/admin/post/delete/{id}", name="admin_post_delete")
 */

public function adminPostDelete($id){

    
}

}
