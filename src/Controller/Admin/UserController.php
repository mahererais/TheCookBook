<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="tcb_admin_user_getAll")
     */
    public function getAll(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('Admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
