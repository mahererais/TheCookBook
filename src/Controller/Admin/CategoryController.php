<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        // dd($category);

        return $this->render('Admin/category/index.html.twig',[
            'controller_name' => 'CategoryController',
        ]);
    }

     /**
     * @Route("/admin/category/delete/{id}", name="tcb_admin_category_delete", requirements={"id" = "\d+"})
     */
    public function delete(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        // ! flash message to add
        $this->addFlash(
            'warning',
            "La catégorie ".$category->getTitle()." a bien été supprimée"
        );

        return $this->redirectToRoute("tcb_admin_category_getAll");
    }

      /**
     * 
     * @Route("/admin/category/add", name="tcb_admin_category_add")
     * 
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "Catégorie correctement ajoutée en BDD.");
        
            return $this->redirectToRoute('tcb_admin_category_getAll');
        }

        return $this->renderForm("Admin/category/form.html.twig",[
            "form" => $form
        ]);
    }

     /**
     * 
     * @Route("/admin/category/update/{id}", name="tcb_admin_category_update", requirements={"id" = "\d+"})
     * 
     */
    public function update(Request $request, EntityManagerInterface $entityManager, Category $category, int $id): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "Catégorie correctement modifiée en BDD.");
        
            return $this->redirectToRoute('tcb_admin_category_getAll');
        }

        return $this->renderForm("Admin/category/form.html.twig",[
            "form" => $form,
            "category" => $category,
        ]);
    }

}
