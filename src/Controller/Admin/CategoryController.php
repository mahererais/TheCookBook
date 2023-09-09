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

        return $this->render('Admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }


     /**
     * @Route("/admin/category/delete/{id}", name="tcb_admin_category_delete", requirements={"id" = "\d+"})
     */
    public function delete(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        
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

            $imageCloudUrl =  $request->get("cloudinaryUrl");
            $category->setPicture($imageCloudUrl);

            $entityManager->persist($category);
            $entityManager->flush();


            
            $this->addFlash("success", "Catégorie correctement ajoutée en BDD.");
        
            return $this->redirectToRoute('tcb_admin_category_getAll');
        }

        return $this->renderForm("Admin/category/form.html.twig",[
            "form" => $form,
            "category" => $category
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

            //= I get the url of the image
            $picture = $request->attributes->get('category')->getPicture();
            // = I get the url of the coudinary image
            $imageCloudUrl =  $request->get("cloudinaryUrl"); 
            //= if the url of the image doesn't exist
            if(!$picture) {
                // = I add the upload
                $category->setPicture($imageCloudUrl);
            // = if the url of the image exist and the url of cloudinary image doesn't exist
            }elseif ($picture && !$imageCloudUrl) {
                // = I leave the url of the existing image
                $category->setPicture($picture);
            // = if the url of the image and the url of the cloudinary image exist 
            }else {
                // = I add the upload
                $category->setPicture($imageCloudUrl);
            }

            $entityManager->persist($category);
            $entityManager->flush();

        
            $this->addFlash("success", "Catégorie correctement modifiée en BDD.");
        
            return $this->redirectToRoute('tcb_admin_category_getAll');
        }

        return $this->renderForm("Admin/category/form.html.twig",[
            "form" => $form,
            "category" => $category,
        ]);
    }

}
