<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Form\CategoryType;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function getAll(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();

        // dd($recipes);

        return $this->render('Front/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * @Route("/recipe/query", name="tcb_front_recipe_search")
     */
    public function search(RecipeRepository $recipeRepository, Request $request): Response
    {
        $recipes = $recipeRepository->searchRecipe($request->get("search"));

        // dd($recipes);

        return $this->render('Front/recipe/search.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     *
     * @Route("/recipe/add", name="tcb_front_recipe_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        // dd($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "Recette bien ajoutée !");


            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        return $this->renderForm("Front/recipe/form.html.twig", [
            "form" => $form
        ]);
    }



    /**
     * 
     * @Route("/recipe/update/{id}", name="tcb_front_recipe_update", requirements={"id" = "\d+"})
     *
     */
    public function update(Request $request, EntityManagerInterface $entityManager, Recipe $recipe, int $id): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "La recette a été modifiée.");


            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        return $this->renderForm("Front/recipe/form.html.twig", [
            "form" => $form,
            "recipe" => $recipe,
        ]);
    }

    /**
     * 
     * @Route("/recipe/delete/{id}", name="tcb_front_recipe_delete", requirements={"id" = "\d+"})
     */
    public function delete(Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        // ! ne pas oublier le CSRF
        // if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
        //     $userRepository->remove($user, true);
        // }

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            "La recette ".$recipe->getTitle()." a bien été supprimé :"
        );


        return $this->redirectToRoute("tcb_front_recipe_getAll");
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