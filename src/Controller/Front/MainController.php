<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="tcb_front_main_home")
     */
    public function index(): Response
    {
        return $this->render('Front/home/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
