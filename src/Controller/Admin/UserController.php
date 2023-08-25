<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="app_admin_user_list")
     */
    public function list(): Response
    {
        return $this->render('Admin/user/list.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
