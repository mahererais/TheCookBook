<?php

namespace App\Controller\Front;

use Knp\Snappy\Pdf;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
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
            $randomRecipes = $recipeRepository->findRandomRecipesByCategory($category, 4);
            $categoryRecipes[$category->getTitle()] = $randomRecipes;
        }

        return $this->render('Front/home/index.html.twig', [
            "categoryRecipes" => $categoryRecipes,
        ]);
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

        $html = $this->renderView('Front/TestsWK/home.html.twig', [
            "recipe" => $recipe
        ]);
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'recette.pdf',
        );
    }

    /**
     * @Route("/{slug}/ebook/", name="tcb_front_main_ebook")
     */

    public function ebook(Pdf $knpSnappyPdf, Request $request, EntityManagerInterface $entityManager, User $user, Security $security, RecipeRepository $recipeRepository): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);
        $recipe = $recipeRepository->getEbook($user);

        $ebookRecipes = $recipeRepository->findBy([
            'user' => $user,
            'ebook' => true,
        ]);


        // = creation of a table to concentrate all the recipes by category in the array :
        $groupedRecipes = [];

        // = each recipe with the same category
        foreach ($ebookRecipes as $recipe) {
            $categoryName = $recipe->getCategory()->getTitle();
        }

        // = creation of an empty array if the category doesn't exists
        if (!isset($groupedRecipes[$categoryName])) {
            $groupedRecipes[$categoryName] = [];
        }

        // = adding the recipe to the category array
        $groupedRecipes[$categoryName][] = $recipe;


        $knpSnappyPdf->setOption('enable-local-file-access', true);

        //       return $this->render('Front/TestsWK/ebook.html.twig', [
        // 'controller_name' => 'MainController',
        // 'recipe' => $recipe,
        // 'ebookRecipes' => $ebookRecipes
        //]);

        //dd($ebookRecipes);
        $html = $this->renderView('Front/TestsWK/ebook.html.twig', [
            
            'recipe' => $recipe,
            'ebookRecipes' => $ebookRecipes,
            'groupedRecipes' => $groupedRecipes,
        ]);


        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'ebook.pdf',
        );
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
}
