<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Form\CategoryType;
use App\Form\RecipeType;
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
            'controller_name' => 'RecipeController',
        ]);
    }

    /**
     * @Route("/recipe/{id}/{slug}", name="tcb_front_recipe_show", requirements={"id"="\d+"})
     */
    public function show(Recipe $recipe, $slug): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug' => $slug]);

        // dd($recipe);
        return $this->render('Front/recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

      /**
     * 
     * @Route("/recipe/add", name="tcb_front_recipe_add")
     * 
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        //dd($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "Recette bien ajoutée !");
        
            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        return $this->renderForm("Front/recipe/form.html.twig",[
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

        return $this->renderForm("Front/recipe/form.html.twig",[
            "form" => $form,
            "recipe" => $recipe,
        ]);
    }
}
