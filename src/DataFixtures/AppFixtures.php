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


        // = ============ USER handler
        
        $userList = [
            "admin" => "ROLE_ADMIN",
            "maher" => "ROLE_USER", 
            "manuella" => "ROLE_USER", 
            "marie" => "ROLE_USER", 
            "oumar" => "", 
            "simon" => "ROLE_USER"];
        foreach ($userList as $userName => $userRole) {
            
            $user = new User();
            $user->setEmail("$userName@gmail.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 123456));
            $user->setRoles([$userRole]);
            $user->setFirstname($userName);

            $manager->persist($user);
        }


        // = ============ CATEGORY handler

        $categoryList = ["Apéritifs", "Entrées", "Plats", "Desserts"];

        $categories = [];

        foreach ($categoryList as $categoryTitle) {
            $category = new Category;

            $category->setTitle($categoryTitle);
            $category->setSlug($this->slugger->slug($category->getTitle()));

            $categories[] = $category;

            $manager->persist($category);
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


            // randomize either public or private status
            $random = mt_rand(0, 1);
            if ($random) {
                $recipe->setStatus("public");
            } else {
                $recipe->setStatus("privé");
            }

            $recipe->setSlug($this->slugger->slug($recipe->getTitle()));
            $recipe->setCategory($categories[array_rand($categories)]);

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
