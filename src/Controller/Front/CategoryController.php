<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="tcb_front_category_getAll")
     */
    public function getAll(CategoryRepository $categoryRepository, EntityManagerInterface $manager): Response
    {
        // $movies = $manager->getRepository(Movie::class)->findAll();
        $categories = $manager->getRepository(Category::class)->findAll();

        dd($categories);
        
        return $this->render('Front/category/index.html.twig', [
            'categories' => $categories,
            'controller_name' => 'RecipeController',
        ]);

        
    }

    /**
     * @Route("/category/{id}/{slug}", name="tcb_front_category_show", requirements={"id"="\d+"})
     * 
     * display one category by id
     */
    public function show(Category $category): Response
    {

        dd($category);

        return $this->render('Front/category/index.html.twig',[
            'controller_name' => 'CategoryController',
        ]);
    }
}
