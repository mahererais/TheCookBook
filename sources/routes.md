# Routes

## FontOffice

- ### Home

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | name |
|--|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | The Cook Book | show the most recent recipes published by the users  | - | tcb_front_main_home |
| `/legal-mentions/` | `GET` | `MainController` | `legalMentions` | Mentions Légales | Legal Mentions | - | tcb_front_main_legalMentions |

- ### Category

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name |
|--|--|--|--|--|--|--|--|
| `/categories` | `GET` | `CategoryController` | `getAll` | Categories | show all categories | - | tcb_front_category_getAll |
| `/category/{slug}` | `GET` | `CategoryController` | `show` | Recette - "category-name" | show all recipes by category id | - | tcb_front_category_show |

- ### Security

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/login` | `GET` | `SecurityController` | `login` | Connexion ou S'inscrire | Button Connection or  Registration |  | tcb_front_security_login |
| `/register` | `POST` | `RegistrationController` | `register` | # | Form identification |  | tcb_front_security_register |
| `/login` | `POST` | `SecurityController` | `login` | # | Form connection |  |tcb_front_security_login |
| `/logout` | `POST` | `SecurityController` | `logout` | Déconnexion | End of the connected session |  | tcb_front_security_logout |
| `/404/` | `GET` | `MainController` | `404` | Page 404 | Page not found | - | tcb_front_main_404 |
| `/403/` | `GET` | `MainController` | `403` | Page 403 | Access denied | - | tcb_front_main_403 |
| `/500/` | `GET` | `MainController` | `500` | Page 500 | Server error | - | tcb_front_main_500 |


- ### User

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/users` | `GET` | `UserController` | `getAll` | Liste des chefs | List of the professionnal user who allow people to see their profile |  | tcb_front_user_getAll |
| `/user/{slug}` | `GET` | `UserController` | `show` | Profil de <user_name> | Profile | {slug} Username of a professionnal user who allows people to see his profile | tcb_front_user_show |
| `/user/update/{id}` | `GET` | `UserController` | `update` | Profil de <user_name> | Profile |  {id} user id, {slug} Username | tcb_front_user_update |
| `/user/pdf/{id}` | `GET` | `MainController` | `PdfAction` | créer un PDF | PDF of a given recipe |  | tcb_front_main_pdf |


- ### Favorites

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/favorites` | `GET` | `FavoriteController` | `getAll` |Liste de Favoris| List of favorite | activation of the "favorite" tab of recipes via the navbar when the user is connected | tcb_front_favorite_getAll|
| `/favorite/add/{id}` | `POST` | `FavoriteController` | `add` |Ajout d'un Favori| Add a favorite | id is the id of the recipe we want to add as a favorite | tcb_front_favorite_add|
| `/favorite/remove/{id}` | `POST` | `FavoriteController` | `remove` |Suppression d'un favori| Remove a favorite | id is the id of the recipe we want to delete as a favorite | tcb_front_favorite_remove |
| `/favorite/empty` | `POST` | `FavoriteController` | `empty` |Suppression de tous les favoris| Remove all the favorites |  | tcb_front_favorite_empty |

- ### Recipe

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/recipes` | `GET` | `RecipeController` | `getAll` | #Name of recipe# | Recettes | list of all recipes | tcb_front_recipe_getAll
| `/recipe/{slug}` | `GET` | `RecipeController` | `show` | #Name of recipe# | Recettes | {slug} the recipe name  | tcb_front_recipe_show
| `/recipe/add` | `POST` | `RecipeController` | `add` | #Name of recipe# | - | create new recipe | tcb_front_recipe_add
| `/recipe/add` | `GET` | `RecipeController` | `add` | # | Ajout d'une recette | form add recipe | tcb_front_recipe_add
| `/recipe/update/{id}` | `POST` | `RecipeController` | `update` | #Name of recipe# | - | update new recipe | tcb_front_recipe_update
| `/recipe/delete/{id}` | `POST` | `RecipeController` | `delete` | #Name of recipe# | - | delete recipe by {id} | tcb_front_recipe_delete
| `/recipe/query` | `GET` | `RecipeController` | `search` | Résultats de votre recherche | - | search recipe by {title} | tcb_front_recipe_search


<hr>
<br>

## BackOffice / Admin

- ### User

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/admin/users` | `GET` | `UserController` | `getAll` | Liste des utilisateurs | the profil of the user | | tcb_admin_user_show
| `/admin/user/{id}` | `GET` | `UserController` | `show` | Voir un utilisateur | list of users | | tcb_admin_user_getAll
| `/admin/user/delete/{id}` | `POST` | `UserController` | `delete` | # | suppression of one user |  | tcb_admin_user_delete


- ### Recipe

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/admin/recipes` | `GET` | `RecipeController` | `getAll` | Liste des recettes| list of recipes |  | tcb_admin_recipe_getAll |
| `/admin/recipe/{id}` | `GET` | `RecipeController` | `show` |  | list of one recipe | with the option of deleting it | tcb_admin_recipe_show |
| `/admin/recipe/delete/{id}` | `GET` | `RecipeController` | `delete` | # | suppression of one recipe | {id} is the id of the recipe | tcb_admin_recipe_delete |

- ### Category

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/admin/categories` | `GET` | `CategoryController` | `getAll` | Liste des Catégories | list of categories |  | tcb_admin_category_getAll | 
| `/admin/category/add` | `GET` | `CategoryController` | `add` | Ajout d'une catégorie | form add categorie  |  | tcb_admin_category_add |
| `/admin/category/add` | `POST` | `CategoryController` | `add` | # | add new category |  redirect to /admin/categories | tcb_admin_category_add |
| `/admin/category/update/{id}` | `GET` | `CategoryController` | `update` | Modification d'une catégorie | update a category| {id} is the id of the category | tcb_admin_category_update |
| `/admin/category/update/{id}` | `POST` | `CategoryController` | `update` | # | update a category | {id} is the id of the category, redirect to /admin/category | tcb_admin_category_update |
| `/admin/category/delete/{id}` | `POST` | `CategoryController` | `delete` | Suppression d'une catégorie | delete category by {id} | {id} is the id of the category, redirect to /admin/categories | tcb_admin_category_delete |


## Api

| URL | Méthode API | Controller | Méthode | Contenu | Commentaire |
|--|--|--|--|--|--|
| `/api/users/{page}/{count}`|`GET`|`ApiUserController`|`getUserForPageNumber`| get users from server | {page} is the page number, {count} means number of users we want |
| `/api/recipes/{page}/{count}`|`GET`|`ApiRecipeController`|`getRecipeForPageNumber`| get recipes from server | {page} is the page number, {count} means number of recipe we want |

<br>
<br>
<hr>