<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
     /**
     * @Route("/admin", name="tcb_admin_recipe_home")
     */
    public function home (): Response
    {

        return $this->render('Admin/admin_base.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

     /**
     * @Route("/admin/recipes", name="tcb_admin_recipe_getAll")
     */
    public function getAll(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        // dd($recipes);

        return $this->render('Admin/recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * pas de slug en back 
     * @Route("/admin/recipe/{id}", name="tcb_admin_recipe_show", requirements={"id"="\d+"})
     */
    public function show(int $id, RecipeRepository $recipeRepository): Response
    {
        $recipe = $recipeRepository->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }
        return $this->render('Admin/recipe/show.html.twig', [
            'recipe' => $recipe
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
    
    /**
     * 
     * @Route("/recipe/update/{id}", name="tcb_admin_recipe_update", requirements={"id" = "\d+"})
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
        
            return $this->redirectToRoute('tcb_admin_recipe_getAll');
        }

        return $this->renderForm("Admin/recipe/form.html.twig",[
            "form" => $form,
            "recipe" => $recipe,
        ]);
    }

    
}
