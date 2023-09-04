<?php

namespace App\Controller\Front;

use Knp\Snappy\Pdf;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
            $randomRecipes = $recipeRepository->findRandomRecipesByCategory($category, 4); // Replace with your method to fetch random recipes
            $categoryRecipes[$category->getTitle()] = $randomRecipes;
        }
        //dd($categoryRecipes);

        return $this->render('Front/home/index.html.twig', [
            "categoryRecipes" => $categoryRecipes,
        ]);

        // $recipes = $recipeRepository->findAll();
        // $categories = $categoryRepository->findAll();

        // return $this->render('Front/home/index.html.twig', [

        //    "recipes" => $recipes,
        //    "categories" => $categories
        //]);
    }

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    } 

    /**
     * @Route("/pdf/{id}", name="tcb_front_main_pdf", requirements={"id"="\d+"})
     */

    public function pdfAction(Pdf $knpSnappyPdf, Recipe $recipe, $id): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['id' => $id]);
        //dd($recipe);
        $html = $this->renderView('Front/TestsWK/home.html.twig', [
           "recipe" => $recipe
        ]);
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
           'recette.pdf',
        );

        //return $this->render('Front/TestsWK/home.html.twig', [
        //  'controller_name' => 'MainController',
        //  "recipe" => $recipe
        //]);
    }

    /**
     * @Route("/{slug}/ebook/", name="tcb_front_main_ebook")
     */

     public function ebook(Pdf $knpSnappyPdf, UserRepository $userRepository,  Recipe $recipe, $slug): Response
     {
        $recipes = $this->entityManager->getRepository(Recipe::class)->findOneBy(['ebook' => $ebook]);
        dd($recipes);
        $html = $this->renderView('Front/TestsWK/ebook.html.twig', [
           "recipe" => $recipe
        ]);
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        //return new PdfResponse(
        //    $knpSnappyPdf->getOutputFromHtml($html),
        //   'recette.pdf',
        //);

        return $this->render('Front/TestsWK/ebook.html.twig', [
          'controller_name' => 'MainController',
          "recipe" => $recipe
        ]);
     }
}
