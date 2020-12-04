use ics325fa2005;

Create table Recipe(
recipe_id Int Primary key AUTO_INCREMENT,
recipe_name varchar(25),
cook_time Int,
recipe_instructions text,
recipe_image_url varchar(25),
ingredient_count Int
);

Create table User(
user_email varchar(25) Primary key,
pw varchar(100) 
);
Create table Shopping_List(
shopping_list_id Int Primary key AUTO_INCREMENT,
shopping_list_date Datetime,
user_email varchar(25),
foreign key (user_email) references User(user_email)
);
Create table Shopping_List_Recipe(
recipe_id Int,
shopping_list_id Int,
Primary Key(recipe_id, shopping_list_id),
foreign key (recipe_id) references Recipe(recipe_id),
foreign key (shopping_list_id) references Shopping_List(shopping_list_id)    
);
Create table Ingredient(
ingredient_name varchar(50) Primary key
);
Create table Measurement(
measurement_type varchar(10) Primary key 
);
Create table Recipe_Ingredient(
recipe_id Int,
ingredient_name varchar(50),
measurement_type varchar(10),
Primary key(recipe_id,ingredient_name,measurement_type),
measurement_qty float,
foreign key (recipe_id) references Recipe(recipe_id),
foreign key (ingredient_name) references Ingredient(ingredient_name),
foreign key(measurement_type) references Measurement(measurement_type)
);

CREATE TRIGGER `getIngredientCount` 
AFTER INSERT ON `recipe_ingredient` 
FOR EACH ROW UPDATE recipe 
SET ingredient_count = (SELECT COUNT(*) FROM recipe_ingredient WHERE recipe_id = recipe.recipe_id);