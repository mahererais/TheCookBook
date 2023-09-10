<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="tcb_admin_user_getAll")
     */
    public function getAll(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    { 
        $users = $userRepository->findAll();
        
        $users = $paginator->paginate(
            $users, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            20 // = limit by page
        );

        return $this->render('Admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="tcb_admin_user_show")
     */
    public function show(int $id, UserRepository $userRepository, RecipeRepository $recipeRepository): Response
    {
        $user = $userRepository->find($id);
        $recipes = $recipeRepository->findByUser($user);

        return $this->render('Admin/user/show.html.twig', [
            'user' => $user,
            'recipes' => $recipes,
        ]);
    }

     /**
     * @Route("/admin/user/delete/{id}", name="tcb_admin_user_delete", requirements={"id" = "\d+"})
     */
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        
        $this->addFlash(
            'warning',
            "L'utilisateur' ".$user->getFirstname()." a bien été supprimé"
        );

        return $this->redirectToRoute("tcb_admin_user_getAll");
    }


}
