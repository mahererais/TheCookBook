<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\AppProvider;
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

        // ici j'ajoute mon provider personnalisé
        $faker->addProvider(new AppProvider($faker));

        // = ============ CATEGORY handler

        $categoryList = [
            "Apéritifs" => "https://images.unsplash.com/photo-1640209872074-dd584b38f2b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80",
            "Entrées" => "https://images.unsplash.com/photo-1671180401158-8d9d060d4966?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2041&q=80",
            "Plats" => "https://images.unsplash.com/photo-1626075241658-b049d34dc624?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80",
            "Desserts" => "https://images.unsplash.com/photo-1564495584622-0bb3af6f668e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
        ];

        $categories = [];

        foreach ($categoryList as $categoryTitle => $categoryImage) {
            $category = new Category;

            $category->setTitle($categoryTitle);
            $category->setSlug($this->slugger->slug($category->getTitle()));
            $category->setPicture(($categoryImage));

            $categories[] = $category;

            $manager->persist($category);
        }

        echo PHP_EOL . '==== CATEGORY fixture ====> OK ' . PHP_EOL;

        // = ============ USER handler

        $userList = [
            "admin" => "ROLE_ADMIN",
            "maher" => "ROLE_ADMIN",
            "manuella" => "ROLE_ADMIN",
            "marie" => "ROLE_ADMIN",
            "oumar" => "ROLE_ADMIN",
            "simon" => "ROLE_ADMIN",
            "Philippe" => "ROLE_USER",
            "Anne-Sophie" => "ROLE_USER",
            "Nicolas" => "ROLE_USER",
            "Jean-Michel" => "ROLE_USER",
            "Franck" => "ROLE_USER",
            "Colette" => "ROLE_USER",
            "Louise" => "ROLE_USER"
        ];

        $chefs = []; // content list of user with ROLE_USER only

        foreach ($userList as $userName => $userRole) {

            $user = new User();
            $user->setEmail("$userName@gmail.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 123456));
            $user->setRoles([$userRole]);
            $user->setFirstname($userName);
            $user->setLastname($faker->lastName);
            // $user->setPicture(("https://loremflickr.com/450/300/cat?lock=" . mt_rand(1, 120) . ""));
            $user->setPicture($faker->getRandomAvatar());
            $user->setSpeciality($faker->sentence(3));
            $user->setSlug($this->slugger->slug($user->getFirstname()));
            $user->setIsVerified(true);

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

            if (!in_array("ROLE_ADMIN", $user->getRoles())) {
                $chefs[] = $user;
            }

            $manager->persist($user);
            $manager->flush();
        }

        echo '==== USER fixture ====> OK ' . PHP_EOL;

        // = ============ RECIPE handler


        for ($i = 1; $i <= 100; $i++) {
            $recipe = new Recipe();

            $recipeFaker = $faker->getRecipe();

            $recipe->setTitle($recipeFaker['title']);
            $recipe->setPicture($recipeFaker['picture']);
            $recipe->setSteps($faker->paragraphs(4));
            $recipe->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $recipe->setDuration($faker->randomNumber(2));
            $recipe->setIngredients($faker->getIngregients());

            // randomize either true or false of the Ebook boolean
            $randomEbook = mt_rand(0, 1);
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


            // I randomly link the user to the recipe
            /** @var \App\Entity\User */
            $randUser = array_rand($chefs);
            $recipe->setUser($chefs[$randUser]);

            $manager->persist($recipe);
            $manager->flush();
        }

        echo '==== RECIPE fixture ====> OK ' . PHP_EOL;
    }
}
