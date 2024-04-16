<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/categories", name="tcb_front_category_getAll")
     */
    public function getAll(): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render('Front/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{slug}", name="tcb_front_category_show", requirements={"id"="\d+"})
     * 
     * display one category by id
     */
    public function show(RecipeRepository $recipeRepository,
                         string $slug,
                         PaginatorInterface $paginator, 
                         Request $request): Response
    {
        
        // $category = $this->entityManager->getRepository(Category::class)->findOneBy(['slug' => $slug]);
        
        // $recipes = $this->entityManager->getRepository(Recipe::class)->findByCategory($category);
       

        $recipes = $recipeRepository->findByCategory($slug); 

        $recipes = $paginator->paginate(
            $recipes, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            5 // = limit by page
        );

        return $this->render('Front/recipe/list.html.twig', [
            'recipes' => $recipes,
        ]);
    }

}
