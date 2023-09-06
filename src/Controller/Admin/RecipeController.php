<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function getAll(RecipeRepository $recipeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $recipeRepository->findRecipes(); 

        $recipes = $paginator->paginate(
            $recipes, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            20 // = limit by page
        );

        return $this->render('Admin/recipe/list.html.twig', [
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

    
}
