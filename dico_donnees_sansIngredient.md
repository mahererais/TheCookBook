# Dictionnaire de données

## Recipe

|field|type|specificities|description|
|-|-|-|-|
|id |INT |PRIMARY KEY NOT NULL, UNSIGNED, AUTO INCREMENT |The ID of the recipe |
|title | VARCHAR(128) | NOT NULL | Name of the recipe |
|picture | VARCHAR(255) | NOT NULL | URL of the recipe picture |
|steps | TEXT | NOT NULL | Content of the recipe |
|created_at| TIMESTAMP | NOT NULL, DEFAULT current-TIMESTAMP| Date of the recipe publication |
|updated_at| TIMESTAMP | NULL | Date of the recipe updating |
|average_rating | FLOAT | UNSIGNED, NULL | rating average of the linked reviews |
|status | VARCHAR(64) | NOT NULL, DEFAULT public | status of the recipe to switch from public to private depending of the user wish |
|slug | VARCHAR(128) | NOT NULL | URL-friendly slug from Recipe title | 
|duration | SMALLINT | NULL | preparation time on minute |
|user_id | ENTITY | NOT NULL | the name of the author of the recipe |
|category_id | ENTITY |NOT NULL | the category of the recipe |
<!-- ! voir liste ingrédients -->
|ingredient1| SET | NOT NULL | name and quantity of ingredients|
|ingredient2| SET | NOT NULL | name and quantity of ingredients|
|ingredient3| SET | NOT NULL | name and quantity of ingredients|
|ingredient4| SET | NOT NULL | name and quantity of ingredients|
|ingredient5| SET | NOT NULL | name and quantity of ingredients|
|ingredient6| SET | NOT NULL | name and quantity of ingredients|
|ingredient7| SET | NOT NULL | name and quantity of ingredients|
|ingredient8| SET | NOT NULL | name and quantity of ingredients|
|ingredient9| SET | NOT NULL | name and quantity of ingredients|
|ingredient10| SET | NOT NULL | name and quantity of ingredients|


## Favorites

|field|type|specificities|description|
|-|-|-|-|
| user_id | ENTITY | NOT NULL, FOREIGN KEY user as PRIMARY KEY id | the name of the user |
| recipe_id| ENTITY | NOT NULL, FOREIGN KEY recipe as PRIMARY KEY id | recipe favorite |


## Category

|field|type|specificities|description|
|-|-|-|-|
| id |INT |PRIMARY KEY NOT NULL, UNSIGNED, AUTO INCREMENT |The ID of the category |
| title  | VARCHAR(64) | NOT NULL  | Name of the category|
| slug | VARCHAR(64) | NOT NULL | Name of the category|

## Review

|field|type|specificities|description|
|-|-|-|-|
| id | INT |PRIMARY KEY NOT NULL, UNSIGNED, AUTO INCREMENT |The ID of the review |
| content | TEXT | NOT NULL |  content of the review |
| rating | TINYINT | NULL | Rating of te review |
| recipe_id| ENTITY | NOT NULL | recipe of the review |

## User

|field|type|specificities|description|
|-|-|-|-|
| id |INT |PRIMARY KEY NOT NULL, UNSIGNED, AUTO INCREMENT |The ID of the user |
| firstname | VARCHAR(64) | NOT NULL| firstname of the user |
| lastname | VARCHAR(64) | NULL | lastname of the user|
| email | VARCHAR(320) | NOT NULL, UNIQUE | email of the user|
| picture | VARCHAR(255) | NULL | picture of the user |
| password | VARCHAR(64) | NOT NULL | password of the user|
| speciality |  VARCHAR(64) | NULL | speciality of the user|
| experience | TEXT | NULL | professionnal experience or personnal experience |
| presentation | TEXT | NULL | presentation of the user|
| status | VARCHAR(64) | DEFAULT PUBLIC | private or public |
