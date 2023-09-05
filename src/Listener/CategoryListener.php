<?php

namespace App\Listener;

use App\Entity\Category;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryListener
{

    private $slugger;

    public function __construct(SluggerInterface $slugger){
        // injection of the SluggerInterface service in the listener
        $this->slugger = $slugger;
    }

    public function slugifyTitle(Category $category)
    {
        // Génère un slug à partir du titre et l'attribue à la catégorie
        $slug = $this->slugger->slug($category->getTitle())->lower();
        $category->setSlug($slug);
    }


}