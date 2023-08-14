# Routes

## FontOffice

- ### Home

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | The Cook Book | show the most recent recipes published by the users  | - |
| `/legal-mentions/` | `GET` | `MainController` | `legalMentions` | Mentions Légales | Legal Mentions | - |

- ### Category

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/categories` | `GET` | `CategoryController` | `getAll` | Categories | show all categories | - |
| `/categories/{id}` | `GET` | `CategoryController` | `getAllById` | Recette - "category-name" | show all recipes by category id | - |


- ### User

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/user` | `GET` | `UserController` | `` | ## |  |  |


- ### Recipe

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/recipes` | `GET` | `RecipeController` | `getAll` | #Name of recipe# | Recettes | list of all recipes |
| `/recipe/{id}` | `GET` | `RecipeController` | `getAllById` | #Name of recipe# | Recettes | {id} is the id of the category |
| `/recipe/add` | `POST` | `RecipeController` | `add` | #Name of recipe# | - | create new recipe |
| `/recipe/update/{id}` | `POST` | `RecipeController` | `update` | #Name of recipe# | - | update new recipe |
| `/recipe/delete/{id}` | `POST` | `RecipeController` | `delete` | #Name of recipe# | - | delete recipe by {id} |




<hr>
<br>

# BackOffice

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|- ### User

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|


- ### Recipe

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/recipes` | `GET` | `RecipeController` | `getList` | #Name of recipe# | Recettes | list of all recipes |
| `/recipes/{id}` | `GET` | `RecipeController` | `getList` | #Name of recipe# | Recettes | {id} is the id of the category |

- ### Category

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|


<br>
<br>
<hr>

# BackOffice

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|