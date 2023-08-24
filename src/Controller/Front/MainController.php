<?php

namespace App\Controller\Front;

use Knp\Snappy\Pdf;
use Twig\Environment;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\Output;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="tcb_front_main_home")
     */
    public function index(RecipeRepository $recipeRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $categoryRecipes = [];
        foreach ($categories as $category) {
            $randomRecipes = $recipeRepository->findRandomRecipesByCategory($category, 4); // Replace with your method to fetch random recipes
            $categoryRecipes[$category->getTitle()] = $randomRecipes;
        }

        return $this->render('Front/home/index.html.twig', [
            "categoryRecipes" => $categoryRecipes
        ]);

        // $recipes = $recipeRepository->findAll();
        // $categories = $categoryRepository->findAll();

        // return $this->render('Front/home/index.html.twig', [

        //    "recipes" => $recipes,
        //    "categories" => $categories
        //]);
    }

    /**
     * @Route("/pdf/{id}", name="tcb_front_main_pdf", requirements={"id"="\d+"})
     */

    public function pdfAction(Pdf $knpSnappyPdf, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll($recipe);

        $html = $this->renderView('Front/TestsWK/home.html.twig', [
            "recipes" => $recipes,
            "recipe" => $recipe
        ]);
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'recette.pdf'
        );

        //return $this->render('Front/TestsWK/home.html.twig', [
        //  'controller_name' => 'MainController',
        //]);
    }
}
