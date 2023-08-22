<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
     /**
     * @Route("/admin/recipes", name="tcb_admin_recipe_getAll")
     */
    public function getAll(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        dd($recipes);

        return $this->render('Admin/recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

    /**
     * pas de slug en back 
     * @Route("/admin/recipe/{id}", name="tcb_admin_recipe_show", requirements={"id"="\d+"})
     */
    public function show(int $id, RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->find($id);
        dd($recipes);

        return $this->render('Admin/recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

     /**
     * @Route("/admin/recipe/delete/{id}", name="tcb_admin_recipe_delete", requirements={"id" = "\d+"})
     */
    public function delete(Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($recipe);
        $entityManager->flush();

        // ! flash message to add
        $this->addFlash(
            'warning',
            "La recette ".$recipe->getTitle()." a bien été supprimée"
        );

        return $this->redirectToRoute("tcb_admin_recipe_getAll");
    }
}
