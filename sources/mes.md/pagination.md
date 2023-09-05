# pagination handler


- nous allons utiliser le bundle "***KnpPaginatorBundle***"

| KnpPaginatorBundle | source |
| - | - |
| Bundle | https://github.com/KnpLabs/KnpPaginatorBundle |
| video | https://www.youtube.com/watch?v=HDoGHDYkePc |
| template | https://github.com/KnpLabs/KnpPaginatorBundle/tree/master/templates/Pagination |
| installation  | `composer require knplabs/knp-paginator-bundle` |


- récuperer le template `twitter_bootstrap_v4_pagination.html.twig` dans [github de KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle/blob/master/templates/Pagination/twitter_bootstrap_v4_pagination.html.twig).
- créer un fragment twig dans `template\Front\fragments` et copier le contenu dans `template\Front\fragments\_paginator.html.twig`


- on va maintenant dans notre controller `src\Controller\Front\RecipeController.php`, et au lieu de récuperer toutes les recettes, on va utilisé notre `KnpPaginatorBundle`
    > c'est le même principe pour la gestion des `Recipes`` dans `admin`

```php
    /**
     * @Route("/recipes", name="tcb_front_recipe_getAll")
     */
    // = besoin de PaginatorInterface et de la requete 
    public function getAll( RecipeRepository $recipeRepository,
                             UserRepository $users, 
                             PaginatorInterface $paginator, 
                             Request $request): Response
    {
        $recipes = $recipeRepository->findBy(
            [],
            ['created_at' => 'DESC'], 
        );

        $recipes = $paginator->paginate(
            $recipes, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            10 // = limit by page
        );


        return $this->render('Front/recipe/list.html.twig', [
            'recipes' => $recipes,
            'users' => $users
        ]);
    }
```

- dans mon template `template\Front\recipe\list.html.twig`, commenter notre `button` "***voir plus***" et ajouter ceci avant la fermeture de notre `block body`
  ```twig
    {# display navigation #}
	<div class="tcb_pagnination">
		{{ knp_pagination_render(recipes, 'Front/fragments/_paginator.html.twig') }}
	</div>
	{# <button type="button" class="tcb_btn">Voir plus</button> #}
  ```




>   ## ⚠️ quand vous avez une erreur, essayer de ***clear le cache***
> ```console
> $ php bin/console cache:clear
> ```

<hr>
<br>

- on fait la même chose pour la liste des chefs 

- **⚠️** : pour récuperer la liste des utisateurs qui ont à la fois un role ***user*** et un status ***public***, j'ai du faire une requête custome mais ***impossible*** de filtrer par le role (qui est de type "json" pour symfony).
- recherche sur le net : [FILTER USERS BY ROLE IN SYMFONY 5](https://endelwar.it/2020/08/filter-users-by-role-in-symfony-5/)
  - installation du packages : [ScientaNL/DoctrineJsonFunctions](https://github.com/ScientaNL/DoctrineJsonFunctions)
    ```console
    $ composer require scienta/doctrine-json-functions
    ```
  - ajouter la requête custome dans `src/Repository/UserRepository.php`
    ```php
    /**
     * find all users with given role 
     * @param string $role : role of user we look like
     * @return void
     */
    public function findByRoleAndStatus(string $role, string $status = "")
    {
        $role = mb_strtoupper($role);

        return $this->createQueryBuilder('u')
            ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
            ->setParameter('role', '"ROLE_' . $role . '"')
            ->andWhere('u.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }
    ```
  - recuperation des chefs  `src/Controller/UserController.php`
    ```php
    /**
     * @Route("/users", name="tcb_front_user_getAll")
     */
    public function getAll(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $userRepository->findByRoleAndStatus('user', "public");
        ..................
        ..................
    ```  
  