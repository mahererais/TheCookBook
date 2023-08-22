<?php

namespace App\Listener;

use App\Entity\Recipe;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeListener
{

    private $slugger;

    public function __construct(SluggerInterface $slugger){
        $this->slugger = $slugger;
    }

    public function slugifyTitle(Recipe $recipe){

        $recipe->setSlug($this->slugger->slug($recipe->getTitle()));

    }

}