<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
 
    //CRUD POST

/**
 * 
 * @Route("/admin/post", name="admin_post")
 */

 public function adminPost() {
    $repo = $this -> getDoctrine() -> getRepository(Post::class); // 
    $posts = $repo -> findAll();

    return $this -> render('admin/post_list.html.twig', [
        'posts' => $posts,
    ]);
 }

/**
 * 
 * @Route("/admin/post/add", name="admin_post_add")
 */

public function adminPostAdd(Request $request){


    $post = new Post; // objet vide
    
    $form = $this -> createForm(PostType::class, $post);
    // On récupère un formulaire PostType, et on le lie notre objet $post

    $form -> handleRequest($request);
    //Elle lie définitivement l'objet $post aux infos saisies dans le formulaire ($_POST)

    if($form -> isSubmitted() && $form -> isValid()){
        $manager = $this -> getDoctrine() -> getManager();
        $manager -> persist($post); // enregistre notre post dans le système
        
        $post -> setDatePosted(new \DateTime('now'));
        $post -> uploadFile(); // prend la photo, la renomme, l'enregistre en BDD et l'enregistre dans le dossier photo
        $manager -> flush();

        $this -> addFlash('success', 'Le post n°' . $post -> getId() . ' a bien été ajouté !');
        return $this -> redirectToRoute('home');
    }

    // $manager = $this -> getDoctrine() -> getManager();
    // $manager -> persist($post); // enregistre notre post dans le systeme
    // $post -> setImage('neymar.jpg');
    // $manager -> flush();

    // return $this -> redirectToRoute('home');
    // test : localhost:8000/admin/post/add
    return $this -> render('admin/post_form.html.twig', array(
        'postForm' => $form -> createView()
    ));
    
}

/**
 * 
 * @Route("/admin/post/update/{id}", name="admin_post_update")
 */

public function adminPostUpdate($id, Request $request){
    // 1: Récupérer les infos du post (id)
    $manager = $this -> getDoctrine() -> getManager();
    $post = $manager -> find(Post::class, $id); //OBJET REMPLI

    // 2: Récupérer le formulaire ate
    $form = $this -> createForm(PostType::class, $post);

    // 3: Traiter les infos du formulaire (BDD + redirect)
    $form -> handleRequest($request);

    if($form -> isSubmitted() && $form -> isValid()){
        $manager -> persist($post); // enregistre notre post dans le système
        if($post -> getFile()){
            $post -> removeFile(); // Supprimer l'image, actuelle
            $post -> uploadFile(); // uploader l'image en cours
        }
        $manager -> flush();

        $this -> addFlash('success', 'Le post n°' . $post -> getId() . ' a bien été modifié !');
        return $this -> redirectToRoute('admin_post');
    }

    // 4 : Afficher le formulaire avec les infos dedans
    return $this -> render('admin/post_form.html.twig', array(
        'postForm' => $form -> createView(),

    ));

    
}

/**
 * 
 * @Route("/admin/post/delete/{id}", name="admin_post_delete")
 */

public function adminPostDelete($id){

    $manager = $this -> getDoctrine() -> getManager();
    $post = $manager -> find(Post::class, $id);

    $post = $manager -> remove($post);
    $manager -> flush();

    $this -> addFlash('success', 'Le post N°' . $id . ' a bien été supprimé !');
    return $this -> redirectToRoute('admin_post');
    
}
// A FAIRE : INSCRIPTION!!!!!!
    //      -> Créer le UserController 
    //      -> Créer la route inscription 
    //      -> créer le Formulaire UserType (User)
    //      -> Afficher le formulaire dans la vue 
    //      -> Récupérer les données du formulaire pour les enregistrer dans la BDD
    
    

}
