<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\Comment;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */

     public function home(){
         //1 : Recuperer les donnees (tous les post)
        $repository = $this -> getDoctrine() -> getRepository(Post::class); // 
        $posts = $repository -> findAll();
        // on demande a doctrine le repository des post (outil aui permet d'interagir avec la table post). Puis on lui demande de tout recuperer).

        //1.2 : Recuperer les categories existantes :
        $categories = $repository -> findAllCategories();
        // $manager = $this -> getDoctrine() -> getManager();
        // $builder = $manager -> createQueryBuilder();//construire n'importe quelle requete
        // $categories = $builder
        //     -> select( 'p.category' )
        //     -> distinct('true')
        //     -> from(Post::class, 'p')
        //     -> orderBy('p.category', 'ASC')
        //     -> getQuery()
        //     -> getResult();

         //2 : Affiche la vue avec les donnees 
        return $this -> render('post/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories
        ]);
     }

     //Route affiche 1 post

     /**
      * @Route("/post/{id}", name="affiche_post")
      */
      public function affichePost($id){
        //1 : Recuperer les infos du post
        $manager = $this -> getDoctrine() -> getManager();

        $post = $manager -> find(Post::class , $id);

        //1.2 : Recuperer les commentaires de ce post
        $repo = $this -> getDoctrine() -> getRepository(Comment::class);
        $comments = $repo -> findby(['idPost' => $id], ['datePosted' => 'DESC']);

        //2 : Affiche la vue avec les donnees
        return $this -> render('post/post.html.twig', [
            'post' => $post,
            'comments' => $comments
        ]);

      }
      /**
         * 
         *
         * 
         * @Route("/category/{cat}", name="category")
         */

        public function categorie($cat){
            //1 : Recuperer les donnees (Les categories, les posts)
           $repo = $this -> getDoctrine() -> getRepository(POST::class);
           $posts = $repo -> findBy(['category' => $cat]);

           $manager = $this -> getDoctrine() -> getManager();
           $builder = $manager -> createQueryBuilder();//construire n'importe quelle requete
           $categories = $builder
               -> select( 'p.category' )
               -> distinct('true')
               -> from(Post::class, 'p')
               -> orderBy('p.category', 'ASC')
               -> getQuery()
               -> getResult();

            //2 : Afficher le vue et transmettre les donnees

            return $this -> render("post/index.html.twig", [
                'posts' => $posts,
                'categories' => $categories
            ]);
        }

      

     // Route pour afficher tous les posts d'une categorie
     //Route pour la recherche

     // Admin : Ajouter/Supprimer/modifier/afficher
    
}
