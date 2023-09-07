<?php

namespace App\Controller\Front;

use Knp\Snappy\Pdf;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
use App\Service\CssService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
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
        //dd($categories);

        return $this->render('Front/home/index.html.twig', [
            "categories" => $categories,
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
        $html = $this->renderView('Front/pdf/recipe.html.twig', [
           "recipe" => $recipe
        ]);
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'recette.pdf',
        );
    }

    /**
     * download ebook on pdf format
     * 
     * @Route("/{slug}/ebook/", name="tcb_front_main_ebook")
     */
    public function ebook(Pdf $knpSnappyPdf, User $user, RecipeRepository $recipeRepository, CategoryRepository $categoryRepository): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);

        $recipes = [];
        
        // = get list of categories
        $recipes = $recipeRepository->getEbook($user);

        // = for each category of the array of categories
        //foreach ($categories as $category) {
            // = find all the recipes by categories
        //    $recipesByCategory = $recipeRepository->findByCategory($category->getSlug()); 
            // = $recipe = [
            // =    'Plat' => [
            // =           "ma recette 1", 
            // =           "ma recette 2", 
            // =           "ma recette 3", 
            // =     ],
            // =    'Entree' => [
            // =           "ma recette 1", 
            // =           "ma recette 2", 
            // =           "ma recette 3", 
            // =     ],
            // =  ]
            // = in the array $recipes[] I 
        //    $recipes[$category->getTitle()] = $recipesByCategory;
        //}


        $ebookRecipes = $recipeRepository->findBy([
            'user' => $user,
            'ebook' => true,
        ]);

        // dd($recipes);

        $html = $this->renderView('Front/pdf/ebook.html.twig', [
            "recipes" => $recipes,
            'ebookRecipes' => $ebookRecipes
         ]);

        $knpSnappyPdf->setOption('enable-local-file-access', true);

         //       return $this->render('Front/TestsWK/ebook.html.twig', [
         // 'controller_name' => 'MainController',
         // 'recipe' => $recipe,
         // 'ebookRecipes' => $ebookRecipes
        //]);


        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'ebook.pdf',
        );
    }

    /**
     * @Route("/legal-mentions", name="tcb_front_main_legalMentions")
     */

     public function legalMentions(){ 

        return $this->render('Front/home/legal_mentions.html.twig');
     }

     /**
     * @Route("/about", name="tcb_front_main_about")
     */

     public function about(){
        
        return $this->render('Front/home/about.html.twig');
     }

}