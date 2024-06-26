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
    public function ebook(Pdf $knpSnappyPdf, User $user, RecipeRepository $recipeRepository): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);


        // = get list of categories
        // $recipes = $recipeRepository->getEbook($user);
        $ebookRecipes = $recipeRepository->findBy([
            'user' => $user,
            'ebook' => true,
        ]);

        // Counting how many recipes selected in ebook
        $ebookRecipesCount = count($ebookRecipes);

        // conditionning render
        if ($ebookRecipesCount > 0) {

            $html = $this->renderView('Front/pdf/ebook.html.twig', [
                "recipes" => $ebookRecipes,
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
        } else {
            return $this->render('Front/user/ebook_empty.html.twig');
        }
    }

    /**
     * @Route("/legal-mentions", name="tcb_front_main_legalMentions")
     */

    public function legalMentions()
    {

        return $this->render('Front/home/legal_mentions.html.twig');
    }

    /**
     * @Route("/about", name="tcb_front_main_about")
     */

    public function about()
    {

        return $this->render('Front/home/about.html.twig');
    }

    /**
     * @Route("/cgu", name="tcb_front_main_cgu")
     */

     public function cgu()
     {
 
         return $this->render('Front/home/cgu.html.twig');
     }
}
