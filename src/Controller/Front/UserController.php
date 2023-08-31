<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     *  @Route("/profile/update/{slug}", name="tcb_front_user_update")
     */
    public function update(Request $request, EntityManagerInterface $entityManager, User $user, Security $security): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            // flash message to add
            $this->addFlash("success", "L'utilisateur a bien mis à jour !");


            return $this->redirectToRoute('tcb_front_user_profile');
        }

        return $this->renderForm("Front/user/update.html.twig", [
            "form" => $form,
            "user" => $user
        ]);
    }

    /**
     * @Route("/profile/{slug}", name="tcb_front_user_profile")
     */
    public function profile(Request $request, EntityManagerInterface $entityManager, User $user, Security $security, UserRepository $userRepository, $slug): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);

            $user = $userRepository->findOneBy(['slug' => $slug]);
            return $this->render('Front/user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/{slug}/recipes", name="tcb_front_user_getRecipesByUserLog")
     */
    public function getRecipesByUserLog(Request $request, EntityManagerInterface $entityManager, User $user, Security $security): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);
        return $this->render('Front/user/recipes.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/{slug}/ebook", name="tcb_front_user_ebook")
     */
    public function ebook(Request $request, EntityManagerInterface $entityManager, User $user, Security $security, RecipeRepository $recipeRepository): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);
        $ebookRecipes = $recipeRepository->findBy([
            'user' => $user,
            'ebook' => true,
        ]);

        return $this->render('Front/user/ebook.html.twig', [
            'user' => $user,
            'ebookRecipes' => $ebookRecipes
        ]);
    }

    // /**
    //  * @Route("/profile/{slug}/ebook/delete", name="removeFromEbook")
    //  */
    // public function removeFromEbook(Recipe $recipe): Response
    // {
    //    //!A TERMINER


    // }
}
