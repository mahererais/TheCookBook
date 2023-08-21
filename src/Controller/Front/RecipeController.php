<?php

namespace App\Controller\Front;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipes", name="tcb_front_recipe_getAll")
     */
    public function getAll(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        dd($recipes);

        return $this->render('Front/recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

    /**
     * @Route("/recipe/{id}/{slug}", name="tcb_front_recipe_show", requirements={"id"="\d+"})
     */
    public function show(int $id, RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->find($id);
        dd($recipes);

        return $this->render('Front/recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}
