<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user/signIn", name="signIn")
     */
    public function userSignIn(Request $request){
        $user = new User;

        $form = $this -> createForm(UserType::class, $user);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($user);

            $manager -> flush(); 

            $this -> addFlash('sucess', 'L\'utilisateur a bien été crée !');
            return $this -> redirectToRoute('home');
        }

        return $this -> render('user/signIn_form.html.twig', array(
            'userForm' => $form-> createView()
        ));

    }
}
