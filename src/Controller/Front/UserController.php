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
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
    public function show(User $user, $slug): Response
    {
        $recipe = $this->entityManager->getRepository(User::class)->findOneBy(['slug' => $slug]);

        // dd($recipe);
        return $this->render('Front/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/search", name="tcb_front_user_search")
     */
    public function search(UserRepository $userRepository, Request $request): Response
    {
        $users = $userRepository->searchUser($request->get("query"));

        return $this->render('Front/user/search.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/profile/{slug}", name="tcb_front_user_profile")
     */
    public function profile(Request $request, EntityManagerInterface $entityManager, User $user, Security $security): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "L'utilisateur a bien mis à jour !");


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

            return $this->redirectToRoute('tcb_front_user_profile', ["id" => $id]);
        }



        return $this->render('user/update.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{slug}/recipes", name="tcb_front_user_getRecipesByUser")
     */
    public function getRecipesByUser(Request $request, EntityManagerInterface $entityManager, User $user, Security $security): Response
    {
        return $this->render('Front/user/recipes.html.twig', [
            'user' => $user,
        ]);
    }
}
