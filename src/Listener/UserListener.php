<?php

namespace App\Listener;

use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserListener
{

    private $slugger;

    public function __construct(SluggerInterface $slugger){
        $this->slugger = $slugger;
    }

    public function slugifyTitle(User $user){

        $user->setSlug($this->slugger->slug($user->getFirstname()));

    }

}