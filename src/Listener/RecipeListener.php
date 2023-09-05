<?php

namespace App\Listener;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeListener
{

    private $slugger;
    private $entityManager;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        // injecting the slugger service in the listener + entityManager
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
    }

    public function slugifyTitle(Recipe $recipe)
    {
        // creating an initial slug from the title
        $originalSlug = $this->slugger->slug($recipe->getTitle())->lower();
        $slug = $originalSlug;

        // check if the slug alread exists in the data base
        $existingSlugs = $this->getExistingSlugs($recipe);
        $counter = 1;

        // loop until a unique slug has been found
        while (in_array($slug, $existingSlugs)) {
            // incrementing the slug with a +1
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        // definition of the slug with a unique slug
        $recipe->setSlug($slug);
    }

    private function getExistingSlugs(Recipe $recipe)
    {

        $existingSlugs = [];
        $title = $recipe->getTitle();

        // Looking for recipes with the same title
        $existingRecipes = $this->entityManager
            ->getRepository(Recipe::class)
            ->findBy(['title' => $title]);

        // Collecte des slugs existants
        foreach ($existingRecipes as $existingRecipe) {
            $existingSlugs[] = $existingRecipe->getSlug();
        }

        return $existingSlugs;
    }

}