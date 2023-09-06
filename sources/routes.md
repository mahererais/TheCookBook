# Routes

## FontOffice

- ### Home

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | name |
|--|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | The Cook Book | show the most recent recipes published by the users  | - | tcb_front_main_home |
| `/legal-mentions` | `GET` | `MainController` | `legalMentions` | Mentions Légales | Legal Mentions | - | tcb_front_main_legalMentions |
| `/about` | `GET` | `MainController` | `about` | A propos | About the team | - | tcb_front_main_about |


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
| `/logout` | `POST` | `SecurityController` | `logout` | Déconnexion | End of the connected session |  | tcb_front_security_logout |
| `/404/` | `GET` | `MainController` | `404` | Page 404 | Page not found | - | tcb_front_main_404 |
| `/403/` | `GET` | `MainController` | `403` | Page 403 | Access denied | - | tcb_front_main_403 |
| `/500/` | `GET` | `MainController` | `500` | Page 500 | Server error | - | tcb_front_main_500 |


- ### User

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/users` | `GET` | `UserController` | `getAll` | Liste des chefs | List of the professionnal user who allow people to see their profile |  | tcb_front_user_getAll |
| `/user/{slug}` | `GET` | `UserController` | `show` | Profil de <user_name> | Profile | {slug} Username of a professionnal user who allows people to see his profile | tcb_front_user_show |
| `/user/{slug}/recipes` | `GET` | `UserController` | `getRecipesByUser` | accéder aux recettes publiques d'un user | Acces to the recipe list of a chief |  | tcb_front_user_getRecipesByUser |
| `/profile/{slug}` | `GET` | `UserController` | `profile` | Profil de <user_name> | Profile | {slug} Username of the logged user | tcb_front_user_profile |
| `/profile/{slug}/recipes` | `GET` | `UserController` | `getRecipesByUserLog` | accéder aux recettes d'un user connecté à son compte | Acces to the recipe list of the specific logged user |  | tcb_front_user_getRecipesByUserLog |
| `/profile/{slug}/ebook/delete` | `GET` | `UserController` | `removeFromEbook` | retirer la recette de la liste du ebook |Delete the recipe of the Ebook list |  | tcb_front_user_removeFromEbook |
| `/profile/{slug}` | `GET` | `UserController` | `profile` | Profil de <user_name> | Profile | {slug} Username of the logged user | tcb_front_user_profile |
| `/profile/update/{slug}` | `GET` | `UserController` | `update` |Update of the <user_name> |profile Profile | {slug} Username | tcb_front_user_update |
| `/profile/{slug}/ebook` | `GET` | `UserController` | `ebook` | Ebbok recipes <user_name> | List of recipes that the connected user wants to appear in his ebook  | {slug} Username | tcb_front_user_ebook |
| `/user/pdf/{id}` | `GET` | `MainController` | `PdfAction` | créer un PDF | PDF of a given recipe |  | tcb_front_main_pdf |



- ### Favorites

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/favorites` | `GET` | `FavoriteController` | `getAll` |Liste de Favoris| List of favorite | activation of the "favorite" tab of recipes via the navbar when the user is connected | tcb_front_favorite_getAll|
| `/favorite/add/{slug}` | `POST` | `UserController` | `addFavorite` |Ajout d'un Favoris| Add a recipe to the favorite list | | tcb_front_user_addFavorite|
| `/favorite/remove/{slug}` | `POST` | `FavoriteController` | `remove` |Suppression d'un favori| Remove a favorite | slug is the name of the recipe we want to delete as a favorite | tcb_front_favorite_remove |
| `/favorites/empty` | `POST` | `FavoriteController` | `empty` |Suppression de tous les favoris| Remove all the favorites |  | tcb_front_favorite_empty |

- ### Recipe

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire | Name|
|--|--|--|--|--|--|--|--|
| `/recipes` | `GET` | `RecipeController` | `getAll` | #Name of recipe# | Recettes | list of all recipes | tcb_front_recipe_getAll
| `/recipe/{slug}` | `GET` | `RecipeController` | `show` | #Name of recipe# | Recettes | {slug} the recipe name  | tcb_front_recipe_show
| `/recipe/add` | `POST` | `RecipeController` | `add` | #Name of recipe# | - | create new recipe | tcb_front_recipe_add
| `/recipe/add` | `GET` | `RecipeController` | `add` | # | Ajout d'une recette | form add recipe | tcb_front_recipe_add
| `/recipe/update/{slug}` | `POST` | `RecipeController` | `update` | #Name of recipe# | - | update recipe by {slug} | tcb_front_recipe_update
| `/recipe/delete/{slug}` | `POST` | `RecipeController` | `delete` | #Name of recipe# | - | delete recipe by {slug} | tcb_front_recipe_delete
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

## Registration


URL | Méthode HTTP | Controller | Méthode | Contenu | Commentaire |
Name|
|--|--|--|--|--|--|--|--|
|`/register`|`GET`|`RegistrationController`|`Register`|User registration form|Inscription|tcb_front_register|
|`/verify/email`|`GET`|`RegistrationController`|`verifyUserEmail`|User registration form|Handle email verification errors|
tcb_verify_email|

## reset

URL | Méthode HTTP | Controller | Méthode | Contenu | Commentaire |
Name|
|--|--|--|--|--|--|--|--|

|`reset-password`|`GET`|`ResetPasswordController`|`request`|Formulaire de demande de réinitialisation de mot de passe|Cette page permet aux utilisateurs de saisir leur adresse e-mail pour demander une réinitialisation de mot de passe|

|`/reset-password/check-email`|`GET`|`ResetPasswordControlle`|`checkEmail`|. Cette page informe l'utilisateur qu'il doit vérifier son e-mail pour le lien de réinitialisation du mot de passe.

|`/reset-password/reset/{token}`|`GET`|`ResetPasswordController`|Formulaire de réinitialisation de mot de passe|
|`/reset-password/reset/{token}`|`POST`|`ResetPasswordController`|`reset`||


<br>
<br>
<hr>