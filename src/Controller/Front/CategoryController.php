<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function getAll(CategoryRepository $categoryRepository): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        // dd($categories);

        return $this->render('Front/category/index.html.twig', [
            'categories' => $categories,
            'controller_name' => 'RecipeController',
        ]);
    }

    /**
     * @Route("/category/{slug}", name="tcb_front_category_show", requirements={"id"="\d+"})
     * 
     * display one category by id
     */
    public function show(Category $category, $slug): Response
    {
        
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['slug' => $slug]);
        $recipes = $this->entityManager->getRepository(Recipe::class)->findByCategory($category);
        // dd($category);

        return $this->render('Front/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

}
