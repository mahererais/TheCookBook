<?php

namespace App\Listener;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserListener
{

    private $slugger;
    private $entityManager;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {

        // injecting the slugger service in the listener + entityManager

        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
    }

    public function slugifyTitle(User $user)
    {
        // creating an initial slug from the last name (less chances of doublon than firstname)
        $initialSlug = $this->slugger->slug($user->getLastName())->lower();
        $slug = $initialSlug;

        // check if there if the slug already exists :
        $existingSlugs = $this->getExistingSlugs($user);
        $counter = 1;

        // loop until a unique slug is found
        while (in_array($slug, $existingSlugs)) {
            // +1 to the slug if exists
            $slug = $initialSlug . '-' . $counter;
            $counter++;
        }

        // creation of the unique slug
        $user->setSlug($slug);
    }

    private function getExistingSlugs(User $user){

        $existingSlugs = [];
        $lastname = $user->getLastname();

        // Looking for users with the same name
        $existingUserNames = $this->entityManager->getRepository(User::class)->findBy(['lastname' => $lastname]);

        // Finding all the same User last names slugs
        foreach ($existingUserNames as $existingUsername) {
            $existingSlugs[] = $existingUsername->getSlug();
        }

        // all the same slug names are now entered in the array $existingSlugs[]
        return $existingSlugs;


    }
}
