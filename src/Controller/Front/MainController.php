<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Knp\Snappy\Pdf;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            $randomRecipes = $recipeRepository->findRandomRecipesByCategory($category, 3); // Replace with your method to fetch random recipes
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
     * @Route("/pdf", name="tcb_front_main_pdf")
     */

    public function pdfAction(Pdf $knpSnappyPdf)
    {
        $html = $this->renderView('Front/TestsWK/home.html.twig', array());
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
