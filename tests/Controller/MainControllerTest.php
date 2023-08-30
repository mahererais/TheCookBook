<?php

namespace App\Tests\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomeAnonyme(): void
    {
        // equivaut à créer un "faux" navigateur
        $client = static::createClient();

        // On crée une requête sur la racine du site
        $crawler = $client->request('GET', '/');

        // Est ce que la requête a bien renvoyé une reponse 200
        $this->assertResponseIsSuccessful();

        // Je vérifie qu'il y a bien le lien de login dans la page 
        $this->assertSelectorExists("a[href='/login']", "Le lien de connexion n'est pas visible");

        // Je vérifie qu'un anonyme ne puisse pas aller sur les favoris
        $this->assertSelectorNotExists("a[href='/favoris']","Malgrès l'anonymat le lien des favoris s'affiche");

    }

    public function testHomeAdmin(): void
    {
       
        $client = static::createClient();

        // Je récup l'userRepository
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Je prend un user de test
        $testUser = $userRepository->findOneByEmail('admin@oclock.io');

        // je connecte l'utilisateur de test
        $client->loginUser($testUser);

        // On crée une requête sur la racine du site
        $crawler = $client->request('GET', '/');
        // Est ce que la requête a bien renvoyé une reponse 200
        $this->assertResponseIsSuccessful();

        // Je vérifie qu'il y a bien le lien de login dans la page 
        $this->assertSelectorExists("a[href='/back-office/film/']", "le lien d'admin n'est pas visible");


    }
}
