<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    public function testGetAll()
    {
        $client = static::createClient();

        $client->request('GET', '/recipes');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Liste des recettes'); 
    }

    
    
}
