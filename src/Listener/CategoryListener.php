<?php

namespace App\Listener;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryListener
{

    private $slugger;

    public function __construct(SluggerInterface $slugger){
        $this->slugger = $slugger;
    }

    public function slugifyTitle(Category $category){

        $category->setSlug($this->slugger->slug($category->getTitle()));

    }

}