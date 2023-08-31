<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
       
    }

    public function testPdfAction(): void
    {
        $client = static::createClient();

        $recipeId = 1;

        $client->request('GET', '/pdf/' . $recipeId);
        $this->assertResponseIsSuccessful();
      
    }
}
