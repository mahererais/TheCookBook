# Dictionnaire de données

## Recipe

|field|type|specificities|description|
|-|-|-|-|
|id |int |Primary Key Not Null, Unsigned, Auto Increment |The ID of the recipe |
|title | VarChar(128) | Not null | Name of the recipe |
|picture | VarChar(255) | Not null | URL of the recipe picture |
|steps | TEXT | Not null | Content of the recipe |
|created_at| TIMESTAMP | not null, default current-TIMESTAMP| Date of the recipe publication |
|updated_at| TIMESTAMP | null | Date of the recipe updating |
|average_rating | FLOAT | Unsigned, null | rating average of the linked reviews |
|status | varChar(64) | Not null, default public | status of the recipe to switch from public to private depending of the user wish |
|user_id | entity | NOT NULL | the name of the author of the recipe |
|ingredient_id | entity | NOT NULL | the ingredient of the recipe |
|category_id | entity |NOT NULL | the category of the recipe |

## Ingredient

|field|type|specificities|description|
|-|-|-|-|
| id | INT | Primary Key Not Null, Unsigned, Auto Increment | ingredient identifier |
| name | VarChar(64) | NOT NULL | ingredient Name |

## Metrics

|field|type|specificities|description|
|-|-|-|-|
| quantity | INT | NOT NULL, Unsigned | quantity of the ingredient|
| unit | VarChar(64) | NOT NULL | choice of unit (grammes, ml, )|
| recipe_id | INT | Primary Key Not Null, Unsigned, Auto Increment | foreign key recipe as primary key id |
| ingredient_id | INT | Primary Key Not Null, Unsigned, Auto Increment | foreign key ingredient as primary key id |

## Category

|field|type|specificities|description|
|-|-|-|-|
|id |int |Primary Key Not Null, Unsigned, Auto Increment |The ID of the category |
|title  | VarChar(64) |Not null  | Name of the category|

## Review

|field|type|specificities|description|
|-|-|-|-|
|id |int |Primary Key Not Null, Unsigned, Auto Increment |The ID of the review |
| content | TEXT | NOT NULL |  content of the review |
| rating | TINYINT | NULL | Rating of te review |
| recipe_id| entity | NOT NULL | recipe of the review |

## User

|field|type|specificities|description|
|-|-|-|-|
|id |int |Primary Key Not Null, Unsigned, Auto Increment |The ID of the user |
| firstname | VarChar(64) | NOT NULL| firstname of the user |
| lastname | VarChar(64) | NULL | lastname of the user|
| email | VarChar(320) | NOT NULL, UNIQUE | email of the user|
| picture | VarChar(255) | NULL | picture of the user |
| password | VarChar(64) | NOT NULL | password of the user|
| speciality |  VarChar(64) | NULL | speciality of the user|
| experience | TEXT | NULL | professionnal experience or personnal experience |
| presentation | TEXT | NULL | presentation of the user|
| status | VarChar(64) | DEFAULT PUBLIC | private or public |
