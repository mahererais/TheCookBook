<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
     * @Route("/user/query", name="tcb_front_user_search")
     */
    public function search(UserRepository $userRepository, Request $request): Response
    {
        $users = $userRepository->searchUser($request->get("search"));

        return $this->render('Front/user/search.html.twig', [
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
     *  @Route("/profile/update/{slug}", name="tcb_front_user_update")
     */
    public function update(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $imageCloudUrl =  $request->get("cloudinaryUrl");
            $user->setPicture($imageCloudUrl);

            $entityManager->persist($user);
            $entityManager->flush();

            // flash message to add
            $this->addFlash("success", "L'utilisateur a bien mis à jour !");


            return $this->redirectToRoute('tcb_front_user_profile', ['slug' => $user->getSlug()]);
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

    /**
     * @Route("/profile/{slug}/ebook/delete{recipeSlug}", name="tcb_front_user_removeFromEbook")
     */
    public function removeFromEbook(RecipeRepository $recipeRepository, $slug, $recipeSlug, EntityManagerInterface $entityManagerInterface): Response
    {
        $user = $this->getUser();
        $recipe = $recipeRepository->findOneBy([
            'slug' => $recipeSlug,
            'user' => $user
        ]);

        if ($recipe && $recipe->isEbook() === '1') {
            $recipe->removeFromEbook();

            $entityManagerInterface->flush();
            $this->addFlash("success", "La recette a été retirée de votre Ebook.");

            return $this->redirectToRoute('tcb_front_user_ebook', ['slug' => $slug]);
        }
    }

    /**
     * @Route("/add-favorite/{id}", name="tcb_front_user_addFavorite")
     */
    public function addFavorite(Request $request, $id, EntityManagerInterface $em, RecipeRepository $recipeRepository): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        // je récupère mon user connecté

        if (!$user) {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion ou affichez un message d'erreur
            return $this->redirectToRoute('login'); // Remplacez 'login' par la route de votre page de connexion
        }
        
        $recipe = $recipeRepository->find($id);

        if (!$recipe) {
            // La recette n'a pas été trouvée, affichez un message d'erreur ou redirigez l'utilisateur
            return $this->redirectToRoute('recipes'); // Remplacez 'recipes' par la route de la liste de recettes
        }

        $user->addFavorite($recipe);
        $favorites = $user->getFavorites();
        
        $em->flush();

        // Affichez un message de succès ou redirigez l'utilisateur vers une autre page
        $this->addFlash('success', 'La recette a été ajoutée à vos favoris.');

        $id = $recipe->getId();

        return $this->render('Front/user/favorites.html.twig', [
            
            'favorites' => $favorites
        ]);
    }
}
