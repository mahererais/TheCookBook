<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="tcb_front_user_getAll")
     */
    public function getAll(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        return $this->render('Front/user/chefs.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/{slug}", name="tcb_front_user_show")
     */
    public function show(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "Recette bien ajoutée !");


            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        return $this->renderForm("Front/user/form.html.twig", [
            "form" => $form, 
            "user" => $user
        ]);

    }

    /**
     * @Route("/user/update/{id}", name="tcb_front_user_update", requirements={"id" = "\d+"})
     */
    public function update(Request $request, EntityManagerInterface $entityManager, User $user, int $id): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($$user);
            $entityManager->flush();

        
            $this->addFlash("success", "Votre profil a bien été modifié");
        
            return $this->redirectToRoute('tcb_front_user_show', ["id" => $id]);
        }



        return $this->render('user/update.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
        ]);
    }
}
