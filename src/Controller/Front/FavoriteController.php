<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorites", name="tcb_front_favorite_getAll")
     * @IsGranted("ROLE_USER")
     */
    public function getAll(): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        $favorites = $user->getFavorites();

        $favoritesByCategories = [];
        // = for each recipe of the array of categories
        foreach ($favorites as $recipe) {
            $categoryTitle = $recipe->getCategory()->getTitle();
           $favoritesByCategories[$categoryTitle][] = $recipe;
        }
        ksort($favoritesByCategories);
   
        return $this->render('Front/user/favorites.html.twig', [
            'favorites' => $favoritesByCategories,
        ]);
    }

    /**
     * @Route("/favorite/remove/{slug}", name="tcb_front_favorite_remove")
     * @IsGranted("ROLE_USER")
     */
    public function remove(RecipeRepository $recipeRepository, $slug, EntityManagerInterface $entityManager): Response
    {
        // pull the connected user
        /** @var \App\Entity\User */
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
     * @IsGranted("ROLE_USER")
     * 
     */
    public function empty(EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();

        $user->getFavorites()->clear();

        $entityManager->flush();

        $this->addFlash("success", "Votre liste de favoris a été vidée");

        return $this->redirectToRoute('tcb_front_favorite_getAll');
    }
}
