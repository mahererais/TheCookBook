<?php

namespace App\Tests\Controller\UserRepository;

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


    }

    

   
}
