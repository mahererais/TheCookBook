<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;


class ExempleTest extends TestCase
{


    private const TEST_CASES = [
        [
            "numbers" => [10,10],
            "result" => 20
        ],
        [
            "numbers" => [5,5],
            "result" => 10
        ],
        [
            "numbers" => [3,2],
            "result" => 5
        ],
        [
            "numbers" => [1022,1020],
            "result" => 2042
        ],
    ];

    public function testPhpUnit(): void
    {

        // je boucle sur mes différents cas de tests
        foreach (self::TEST_CASES as $test) {
            // j'utilise ma fonction d'addition
            $result = $this->addition($test["numbers"][0], $test["numbers"][1]);
            // on affirme qu'on attend le resultat stocké dans notre tableau
            $this->assertEquals($test["result"], $result, "L'addition ne retourne pas le résultat attendu");
        }

    }

    private function addition($num1, $num2){
        return $num1 + $num2;
    }

}
