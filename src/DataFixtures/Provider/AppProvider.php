<?php

namespace App\DataFixtures\Provider;

class AppProvider
{

    private $ingredients = [
        'Farine', 'Sucre', 'Beurre', 'Oeuf', 'Lait', 'Levure', 'Sel', 'Vanille', 'Chocolat', 'Miel', 'Huile', 'Eau', 'Fromage', 'Jambon', 'Pain', 'Tomate', 'Basilic', 'Ail', 'Oignon', 'Carotte', 'Pomme de terre', 'Poulet', 'Riz', 'Curry', 'Laitde coco', 'Poisson', 'Citron', 'Persil', 'Crème fraîche', 'Champignon', 'Pâte feuilletée', 'Pomme', 'Cannelle', 'Noix de muscade', 'Bœuf', 'Vin rouge', 'Laurier', 'Thym', 'Pâtes', 'Sauce tomate', 'Fromage râpé', 'Courgette', 'Aubergine', 'Mozzarella', 'Parmesan', 'Banane', 'Avoine', 'Yaourt', 'Miel', 'Noix', 'Saumon', 'Aneth', 'Concombre', 'Fromage blanc', 'Ciboulette', 'Porc', 'Moutarde', 'Cornichon', 'Pain de mie', 'Beurre', 'Confiture', 'Gruyère Fromage à pâte', 'Jus d’orange', 'Café', 'Croissant',
    ];



    private $recipes = [
        [
            "title" => "Coq au Vin",
            "picture" => "https://img.cuisineaz.com/660x660/2013/12/20/i19968-coq-au-vin.jpeg"
        ],
        [
            "title" => "Boeuf Bourguignon",
            "picture" => "https://img.cuisineaz.com/660x660/2013/12/20/i19968-coq-au-vin.jpeg"
        ],
        [
            "title" => "Ratatouille",
            "picture" => "https://www.foodpal-app.com/uploads/images/meals/3712/ratatouille-mit-hackfleisch-600c1e947b3bd-800.webp",
        ],
        [
            "title" => "Quiche Lorraine",
            "picture" => "https://fgdjrynm.filerobot.com/recipes/d909dfad598b093dd5644768501d75f3d437ac4f7bcb27ee17ccfcc56d6bd7fc.jpg?vh=7b532d",
        ],
        [
            "title" => "Bouillabaisse",
            "picture" => " https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKpqviQisVZeaCAx42-XpoFGh5L2xskdCrfA&usqp=CAU",
        ],
        [
            "title" => "Cassoulet",
            "picture" => "https://www.traditions-perigord.com/2828-home_default/cassoulet-manchon-700g.jpg",
        ],
        [
            "title" => "Confit de Canard",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAjG_033CUke4R4NW6Ii3glv7WbxsdyLJfQw&usqp=CAU",
        ],
        [
            "title" => "Crêpes Suzette",
            "picture" => "https://turbigo-gourmandises.fr/wp-content/uploads/2017/01/crepes-suzette-fait-maison.jpg",
        ],
        [
            "title" => "Soupe à l'Oignon Gratinee",
            "picture" => " https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQY4Hd8uqRRtK_gGjjPXs1H-RvFrPXe2ZurzA&usqp=CAU",
        ],
        [
            "title" => "Tarte Tatin ",
            "picture" => " https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyhjFQ3eUibcxBgXn93WoJpN30irGi_LjQgA&usqp=CAU",
        ],

        [
            "title" => "Salade Niçoise",
            "picture" => "  https://lacuisinedegeraldine.fr/wp-content/uploads/2023/05/salade-nicoise-Geraldine-Leverd-98-2.jpg",
        ],
        [
            "title" => "Gratin Dauphinois ",
            "picture" => "https://www.platetrecette.fr/wp-content/uploads/2020/11/Gratin-dauphinois-au-fromage-blanc.jpg",
        ],
        [
            "title" => "Blanquette de Veau",
            "picture" => "https://mariatotal.com/images/resized/images/uploads/recettes/Blanquette_1200x680.jpg",
        ],
        [
            "title" => "Bouef à la Mode",
            "picture" => "https://www.franzoesischkochen.de/wp-content/uploads/2010/08/DSC_9408-1.jpg",
        ],

        [
            "title" => "Croque-Monsieur",
            "picture" => "https://lacuisineensemble.fr/wp-content/uploads/2022/01/croque-monsieur-bechamel.jpg",
        ],
        [
            "title" => "Moules Marinières ",
            "picture" => "  https://media.houra.fr/images/widget/recette/gd_recette_moules_frites.jpg",
        ],
        [
            "title" => "Oeufs en Meurette",
            "picture" => "https://www.les-freres-popote.fr/251-thickbox_default/l-oeuf-mollet-facon-meurette-de-maman-popote.jpg",
        ],
        [
            "title" => "Pot-au-Feu",
            "picture" => " https://assets.magimix.com/files/rec_55394/pot%20au%20feu_photo.jpg",
        ],
        [
            "title" => "Sole Meunière",
            "picture" => "  https://www.pecheursdebretagne.eu/wp-content/uploads/2016/12/sole-1.jpg",
        ],
        [
            "title" => "Escargots de Bourgogne",
            "picture" => "https://www.lacotedorjadore.com/uploads/external/8abfec31b234da849d43d3343b2baeb2-plat-escargots-decideursenregion_fr_-1-890x0.jpg",
        ],
    ];

    private $avatars = [
        "https://drive.google.com/file/d/1c2nZ4Q7-M-salPi9D0YBtwjMKLODxFCT/view?usp=drive_link",
        "https://drive.google.com/file/d/1OOC0yGsk3HjeUWetATXcC5Ffiwjyl5Oj/view?usp=drive_link",
        "https://drive.google.com/file/d/17nkg5ZVUONXLSVHQxuDfna7doNstI8Sy/view?usp=drive_link",
        "https://drive.google.com/file/d/15jMXkJ_WrvwT4LtEwRLoOYmQY7Us4NFs/view?usp=drive_link",
        "https://drive.google.com/file/d/10UwN2BmQFBWF4z2zo2uo4N3zDpUUiovV/view?usp=drive_link",
        "https://drive.google.com/file/d/1cbpKunDv8SQ0-fNyhUgsNE1cS2hgAlLW/view?usp=drive_link",
        "https://drive.google.com/file/d/1gakW6y_oH0duEc1I-YwmikAM6ucsdGLf/view?usp=drive_link",
        "https://drive.google.com/file/d/1vaqmH-JLAVq4fdoeOH83hwR90c6H0d3G/view?usp=drive_link",
        "https://drive.google.com/file/d/1bSRAG6nhUymyXirme0mOBdialzkLPIpM/view?usp=drive_link",
        "https://drive.google.com/file/d/17CdUcmFyL04W0RLn6VSW7_rGt_dSaRW2/view?usp=drive_link",
        "https://drive.google.com/file/d/1h-2qLgYZz9NX0-HingKwvLljiQdCnOkL/view?usp=drive_link",
        "https://drive.google.com/file/d/1mBUeaR6_iQ2SqOViT638P9MVbPIlQhOg/view?usp=drive_link",
        "https://drive.google.com/file/d/16ja-b-fmtnmWQ2WCKQ57n6BrH3Xsjub2/view?usp=drive_link",
        "https://drive.google.com/file/d/1i0np8dKf_kte88xQ6Z0WcECNG-O_XSKC/view?usp=drive_link",
        "https://drive.google.com/file/d/18rEYzgNk_ahYX-Fe5iv-VqyLyxj5fuzC/view?usp=drive_link",
        "https://drive.google.com/file/d/1anpKqNQJM14cejCCkFApM8_E8XGvsWCS/view?usp=drive_link",
        "https://drive.google.com/file/d/1aCNW6sx_2EUI7JfzrSGv3TBis9dTGXnk/view?usp=drive_link",
        "https://drive.google.com/file/d/1LGkExDd8wksP_GQjRrMpm5okh3MDTpBd/view?usp=drive_link",
        "https://drive.google.com/file/d/1a-5lSH1_4LHiQFCIHHdSNIorYqF3Urmo/view?usp=drive_link",
        "https://drive.google.com/file/d/1WaBrMty6BTutzuRFslvA0hcnLZef87b4/view?usp=drive_link",
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
