<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Form\CategoryType;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RecipeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/recipes", name="tcb_front_recipe_getAll")
     */
    public function getAll(RecipeRepository $recipeRepository, UserRepository $users): Response
    {
        $recipes = $recipeRepository->findAll();

        // dd($recipes);

        return $this->render('Front/recipe/index.html.twig', [
            'recipes' => $recipes,
            'users' => $users
        ]);
    }

    /**
     * @Route("/recipe/search", name="tcb_front_recipe_search")
     */
    public function search(RecipeRepository $recipeRepository, Request $request): Response
    {
        $recipes = $recipeRepository->searchRecipe($request->get("query"));

        // dd($recipes);

        return $this->render('Front/recipe/search.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     *
     * @Route("/recipe/add", name="tcb_front_recipe_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $recipe = new Recipe();
        $user = $security->getUser();

        // dd($userId);
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        // dd($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser($user);
            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash("success", "Recette bien ajoutée !");

            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        return $this->renderForm("Front/recipe/form.html.twig", [
            "form" => $form
        ]);
    }



    /**
     * 
     * @Route("/recipe/update/{slug}", name="tcb_front_recipe_update")
     *
     */
    public function update(Request $request, EntityManagerInterface $entityManager, string $slug, Recipe $recipe, RecipeRepository $recipeRepository ): Response
    {
        $recipe = $recipeRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "La recette a été modifiée.");

            //dd($slug);
            
            return $this->redirectToRoute('tcb_front_recipe_show', ['slug' => $recipe->getSlug()]);
        }

        return $this->renderForm("Front/recipe/form.html.twig", [
            "form" => $form,
            "recipe" => $recipe,
        ]);
    }

    /**
     * 
     * @Route("/recipe/delete/{slug}", name="tcb_front_recipe_delete")
     */
    public function delete(Recipe $recipe, EntityManagerInterface $entityManager, string $slug, Request $request): Response
    {
        // ! ne pas oublier le CSRF
        // if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
        //     $userRepository->remove($user, true);
        // }
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug' => $slug]);

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            "La recette a bien été supprimé !"
        );

        $referer = $request->headers->get("referer");
        
        return $this->redirect($referer);
    }

    /**
     * @Route("/recipe/{slug}", name="tcb_front_recipe_show")
     */
    public function show(Recipe $recipe, $slug): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug' => $slug]);

        // dd($recipe);
        return $this->render('Front/recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

}