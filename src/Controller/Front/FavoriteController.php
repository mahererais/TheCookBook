<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorites", name="tcb_front_favorite_getAll")
     */
    public function getAll(): Response
    {

        $favorites = $this->getUser()->getFavorites();

        return $this->render('Front/user/favorites.html.twig', [
            'favorites' => $favorites
        ]);
    }

     /**
     * @Route("/favorite/remove/{slug}", name="tcb_front_favorite_remove")
     */
    public function remove(): Response
    {
        return $this->render('Front/user/favorites.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }

    /**
     * @Route("/favorites/empty", name="tcb_front_favorite_empty")
     */
    public function empty(): Response
    {
        return $this->render('Front/user/favorites.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }
}
