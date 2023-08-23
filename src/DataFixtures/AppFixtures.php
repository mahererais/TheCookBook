<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        // j'injecte le service slugger de symfony
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // initialisation of faker
        $faker = Factory::create('fr_FR');



        $categoryList = ["Apéritifs", "Entrées", "Plats", "Desserts"];

        $categories = [];

        foreach ($categoryList as $categoryTitle) {
            $category = new Category;

            $category->setTitle($categoryTitle);
            $category->setSlug($this->slugger->slug($category->getTitle()));

            $categories[] = $category;

            $manager->persist($category);
        }

        for ($i = 1; $i <= 10; $i++) {
            $recipe = new Recipe();

            $recipe->setTitle($faker->text(100));
            $recipe->setPicture($faker->imageUrl(150, 300, "", true));
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
