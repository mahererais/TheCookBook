<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="tcb_admin_category_getAll")
     */
    public function getAll(CategoryRepository $categoryRepository, EntityManagerInterface $manager): Response
    {
        $categories = $manager->getRepository(Category::class)->findAll();

        // dd($categories);

        return $this->render('Admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * pas de slug en backoffice
     * 
     * @Route("/admin/category/{id}", name="tcb_admin_category_show", requirements={"id"="\d+"})
     * 
     * display one category by id
     */
    public function show(Category $category): Response
    {

        dd($category);

        return $this->render('Admin/category/index.html.twig',[
            'controller_name' => 'CategoryController',
        ]);
    }
}
