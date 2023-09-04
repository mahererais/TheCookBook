<?php

namespace App\Controller\Front;

use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function remove(RecipeRepository $recipeRepository, $slug, EntityManagerInterface $entityManager): Response
    {
        // pull the connected user
        $user = $this->getUser();

        // find the recipe to delete from the favorite list
        $recipe = $recipeRepository->findOneBy([
            'slug' => $slug
        ]);

        // verified if the recipe exists in the favorites list of the user
        if ($user->getFavorites()->contains($recipe)) {
            // remove the recipe from the favorites list
            $user->removeFavorite($recipe);

            // save the changes in the database
            $entityManager->flush();
            $this->addFlash("success", "La recette a été retirée de votre liste de favoris.");

            return $this->redirectToRoute('tcb_front_favorite_getAll');
        }
    }
  
    /**
     * @Route("/favorites/empty", name="tcb_front_favorite_empty")
     */
    public function empty(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $user->getFavorites()->clear();

        $entityManager->flush();

        $this->addFlash("success", "Votre liste de favoris a été vidée");

        return $this->redirectToRoute('tcb_front_favorite_getAll');

    }
}
