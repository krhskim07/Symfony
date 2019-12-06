<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i <= 20; $i++){
            $post = new Post();

            $post -> setTitle('Article numero ' .$i);
            $post -> setContent('Lorem ipsum dolor, sit amet consectetur adipisicing elit. Placeat ab fugit asperiores animi hic a iure maxime sapiente ratione incidunt facilis consectetur iste sunt quia natus autem, deleniti corrupti. Saepe.');
            $post -> setImage('image' . rand(1,3) . '.jpg');
            $post -> setDatePosted(new \DateTime('now'));
            $post -> setCategory('categorie' . rand(1,4));
            $manager -> persist($post);
            $manager -> flush();
            for($j = 1 ; $j <= rand(3,6); $j++){
                $comment = new Comment();
                $comment -> setPseudo('user' . rand(1,100));
                $comment -> setContent('Lorem ipsum');
                $comment -> setIdPost($post -> getId());
                $comment -> setDatePosted(new \DateTime('now'));
                $manager -> persist($comment);
            }
            
        }
        $manager -> flush();
    }
}
