<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;
    private $slugger;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $passwordHasher)
    {
        // j'injecte le service slugger de symfony
        $this->slugger = $slugger;
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // initialisation of faker
        $faker = Factory::create('fr_FR');



        // = ============ CATEGORY handler

        $categoryList = ["Apéritifs", "Entrées", "Plats", "Desserts"];

        $categories = [];

        foreach ($categoryList as $categoryTitle) {
            $category = new Category;

            $category->setTitle($categoryTitle);
            $category->setSlug($this->slugger->slug($category->getTitle()));
            $category->setPicture(("https://loremflickr.com/450/300/food?lock=" . mt_rand(1, 120) . ""));

            $categories[] = $category;

            $manager->persist($category);
        }

        // = ============ USER handler

        $userList = [
            "admin" => "ROLE_ADMIN",
            "maher" => "ROLE_ADMIN",
            "manuella" => "ROLE_ADMIN",
            "marie" => "ROLE_ADMIN",
            "oumar" => "",
            "simon" => "ROLE_ADMIN",
            "Philippe" => "ROLE_USER",
            "Anne-Sophie" => "ROLE_USER",
            "Nicolas" => "ROLE_USER",
            "Jean-Michel" => "ROLE_USER",
            "Franck" => "ROLE_USER",
            "Colette" => "ROLE_USER",
            "Louise" =>"ROLE_USER"
        ];
        
        foreach ($userList as $userName => $userRole) {

            $user = new User();
            $user->setEmail("$userName@gmail.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 123456));
            $user->setRoles([$userRole]);
            $user->setFirstname($userName);
            $user->setLastname($faker->lastName);
            $user->setPicture(("https://loremflickr.com/450/300/cat?lock=" . mt_rand(1, 120) . ""));
            $user->setSpeciality($faker->sentence(3));
            $user->setSlug($this->slugger->slug($user->getFirstname()));

            // randomize either professional or amateur cooker
            $randomExperience = mt_rand(0, 1);
            if ($randomExperience) {
                $user->setExperience("professionel");
            } else {
                $user->setExperience("amateur");
            };

            $user->setPresentation($faker->realText($maxNbChars = 200));

            // randomize either public or private status
            $randomStatusUser = mt_rand(0, 1);
            if ($randomStatusUser) {
                $user->setStatus("public");
            } else {
                $user->setStatus("privé");
            }

            // = ============ RECIPE handler

            for ($i = 1; $i <= 20; $i++) {
                $recipe = new Recipe();

                $recipe->setTitle($faker->text(20));
                //$recipe->setPicture($faker->imageUrl(450, 300, "", true));
                $recipe->setPicture("https://loremflickr.com/450/300/food?lock=" . mt_rand(1, 120) . "");
                $recipe->setSteps($faker->paragraphs(4));
                $recipe->setCreatedAt(new \DateTimeImmutable($faker->date()));
                $recipe->setDuration($faker->randomNumber(2));
                $recipe->setIngredients($faker->words(mt_rand(2, 10)));

                // randomize either true or false of the Ebook boolean
                $randomEbook = (bool) mt_rand(0, 1);
                $recipe->setEbook($randomEbook);

                // randomize either public or private status
                $randomStatus = mt_rand(0, 1);
                if ($randomStatus) {
                    $recipe->setStatus("public");
                } else {
                    $recipe->setStatus("privé");
                }

                $recipe->setSlug($this->slugger->slug($recipe->getTitle()));
                $recipe->setCategory($categories[array_rand($categories)]);
                
                $users=[];
                // I randomly link the user to the recipe
                $recipe->setUser($user);
                
                $manager->persist($recipe);
            }

            $manager->persist($user);
        }


        $manager->flush();
    }
}
