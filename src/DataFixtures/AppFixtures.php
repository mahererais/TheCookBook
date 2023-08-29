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
            $category->setPicture($faker->imageUrl(300, 300, "", true));

            $categories[] = $category;

            $manager->persist($category);
        }

        // = ============ USER handler

        $userList = [
            "admin" => "ROLE_ADMIN",
            "maher" => "ROLE_USER",
            "manuella" => "ROLE_USER",
            "marie" => "ROLE_USER",
            "oumar" => "",
            "simon" => "ROLE_USER"
        ];
        foreach ($userList as $userName => $userRole) {

            $user = new User();
            $user->setEmail("$userName@gmail.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 123456));
            $user->setRoles([$userRole]);
            $user->setFirstname($userName);
            $user->setLastname($faker->lastName);
            $user->setPicture($faker->imageUrl(450, 300, "", true));
            $user->setSpeciality($faker->sentence());
            $user->setSlug($this->slugger->slug($user->getFirstname()));

            // randomize either professional or amateur cooker
            $randomExperience = mt_rand(0, 1);
            if ($randomExperience) {
                $user->setExperience("professional");
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
                $recipe->setPicture($faker->imageUrl(450, 300, "", true));
                $recipe->setSteps($faker->paragraphs(4));
                $recipe->setCreatedAt(new \DateTimeImmutable($faker->date()));
                $recipe->setDuration($faker->randomNumber(2));
                $recipe->setIngredients($faker->words(5));

                // randomize either true or false of the Ebook boolean
                $randomEbook = mt_rand(0, 1);
                if ($randomEbook) {
                    $recipe->setEbook("true");
                } else {
                    $recipe->setEbook("false");
                }

                // randomize either public or private status
                $randomStatus = mt_rand(0, 1);
                if ($randomStatus) {
                    $recipe->setStatus("public");
                } else {
                    $recipe->setStatus("privé");
                }

                $recipe->setSlug($this->slugger->slug($recipe->getTitle()));
                $recipe->setCategory($categories[array_rand($categories)]);
                

                // I link the user to the recipe
                $recipe->setUser($user);

                $manager->persist($recipe);
            }

            $manager->persist($user);
        }


        $manager->flush();
    }
}
