<?php

namespace App\DataFixtures\Provider;

class AppProvider
{

    private $ingredients = [
        'Farine', 'Sucre', 'Beurre', 'Oeuf', 'Lait', 'Levure', 'Sel', 'Vanille', 'Chocolat', 'Miel', 'Huile', 'Eau', 'Fromage', 'Jambon', 'Pain', 'Tomate', 'Basilic', 'Ail', 'Oignon', 'Carotte', 'Pomme de terre', 'Poulet', 'Riz', 'Curry', 'Lait de coco', 'Poisson', 'Citron', 'Persil', 'Crème fraîche', 'Champignon', 'Pâte feuilletée', 'Pomme', 'Cannelle', 'Noix de muscade', 'Bœuf', 'Vin rouge', 'Laurier', 'Thym', 'Pâtes', 'Sauce tomate', 'Fromage râpé', 'Courgette', 'Aubergine', 'Mozzarella', 'Parmesan', 'Banane', 'Avoine', 'Yaourt', 'Miel', 'Noix', 'Saumon', 'Aneth', 'Concombre', 'Fromage blanc', 'Ciboulette', 'Porc', 'Moutarde', 'Cornichon', 'Pain de mie', 'Beurre', 'Confiture', 'Gruyère', 'Jus d’orange', 'Café', 'Croissant',
    ];



    private $recipes = [
        [
            "title" => "Pâtes fraiches",
            "picture" => "https://cdn.pixabay.com/photo/2017/11/08/22/18/spaghetti-2931846_1280.jpg"
        ],
        [
            "title" => "Pancakes",
            "picture" => "https://cdn.pixabay.com/photo/2017/03/13/13/39/pancakes-2139844_640.jpg"
        ],
        [
            "title" => "Crêpes",
            "picture" => "https://cdn.pixabay.com/photo/2017/01/30/13/49/pancakes-2020863_640.jpg",
        ],
        [
            "title" => "Verrine à la fraise",
            "picture" => "https://cdn.pixabay.com/photo/2017/03/31/18/02/strawberry-dessert-2191973_640.jpg",
        ],
        [
            "title" => "Canapés au saumon",
            "picture" => " https://cdn.pixabay.com/photo/2010/12/13/10/25/canape-2802_640.jpg",
        ],
        [
            "title" => "Poké bowl",
            "picture" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8Mnx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
        ],
        [
            "title" => "Gâteau aux fruits rouges",
            "picture" => "https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8N3x8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
        ],
        [
            "title" => "Pizza maison",
            "picture" => "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8Nnx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
        ],
        [
            "title" => "Pain perdu",
            "picture" => " https://images.unsplash.com/photo-1484723091739-30a097e8f929?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTJ8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60",
        ],
        [
            "title" => "Saumon et ses petits légumes",
            "picture" => " https://images.unsplash.com/photo-1467003909585-2f8a72700288?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTF8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60",
        ],

        [
            "title" => "Petits gâteaux au chocolat",
            "picture" => "https://cdn.pixabay.com/photo/2016/06/12/15/03/cupcakes-1452178_640.jpg",
        ],
        [
            "title" => "Croissants",
            "picture" => "https://cdn.pixabay.com/photo/2016/03/27/21/59/bread-1284438_640.jpg",
        ],
        [
            "title" => "Couscous",
            "picture" => "https://cdn.pixabay.com/photo/2018/05/29/20/47/couscous-3440042_640.jpg",
        ],
        [
            "title" => "Brochettes",
            "picture" => "https://cdn.pixabay.com/photo/2018/05/03/05/19/skewer-3370443_640.jpg",
        ],

        [
            "title" => "Curry de volaille",
            "picture" => "https://cdn.pixabay.com/photo/2022/06/07/20/52/curry-7249247_640.jpg",
        ],
        [
            "title" => "Tacos",
            "picture" => "https://cdn.pixabay.com/photo/2019/07/21/01/36/tacos-al-pastor-4351813_640.jpg",
        ],
        [
            "title" => "Farfalle au pesto",
            "picture" => "https://cdn.pixabay.com/photo/2016/11/23/18/31/pasta-1854245_640.jpg",
        ],
        [
            "title" => "Quiche lorraine",
            "picture" => "https://cdn.pixabay.com/photo/2018/06/09/01/43/quiche-3463479_1280.jpg",
        ],
        [
            "title" => "Magret de canard",
            "picture" => "https://cdn.pixabay.com/photo/2020/02/02/15/07/meat-4813261_1280.jpg",
        ],
        [
            "title" => "Risotto",
            "picture" => "https://cdn.pixabay.com/photo/2017/07/25/20/42/food-2539485_640.jpg",
        ],
    ];

    private $avatars = [
        "https://cdn.pixabay.com/photo/2018/05/21/12/37/restaurant-3418134_640.png",
        "https://cdn.pixabay.com/photo/2017/07/18/17/16/black-2516434_640.jpg",
        "https://cdn.pixabay.com/photo/2020/09/09/06/03/cooking-5556686_640.png",
        "https://cdn.pixabay.com/photo/2020/08/23/06/54/cooking-5510047_640.png",
        "https://cdn.pixabay.com/photo/2014/10/19/05/00/cook-494022_640.jpg",
    ];

    /**
     * get a random ingredient from the provider
     * @return string random ingredient
     */
    public function getIngregients() : array
    {
        $randArray = array_rand($this->ingredients, mt_rand(2,5));
        $ingredients = [];
        foreach ($randArray as $index) {
            $ingredients[] = $this->ingredients[$index];
        }
        return $ingredients;
    }

    /**
     * get a random recipe from the provider
     * @return string random recipe
     */
    public function getRecipe() : array
    {
        return $this->recipes[array_rand($this->recipes)];
    }

    /**
     * get a random avatar from the provider
     * @return string random movie
     */
    public function getRandomAvatar() : string {
        return $this->avatars[array_rand($this->avatars)];
    }

    
}
