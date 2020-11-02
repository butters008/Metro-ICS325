<?php
    include "recipe.php";
$mockRecipeList = array();
$mockIngredientList = array();
// Generate fake recipe date to use for testing
$mockRecipeData =array(array(1,"recipe 1","Instruction 1", 66),
array(2,"recipe 2","Instruction 2",65.5),
array(3,"recipe 3","Instruction 3",80.53),
array(4,"recipe 4","Instruction 4",82.14),
array(5,"recipe 5","Instruction 5",6.27),
array(6,"recipe 6","Instruction 6",90.45),
array(7,"recipe 7","Instruction 7",97.51),
array(8,"recipe 8","Instruction 8",18.44),
array(9,"recipe 9","Instruction 9",87.76),
array(10,"recipe 10","Instruction 10",22.95),
array(11,"recipe 11","Instruction 10", 66),
array(12,"recipe 12","Instruction 12",65.5),
array(13,"recipe 13","Instruction 13",80.53),
array(14,"recipe 14","Instruction 14",82.14),
array(15,"recipe 15","Instruction 15",6.27),
array(16,"recipe 16","Instruction 16",90.45),
array(17,"recipe 17","Instruction 17",97.51),
array(18,"recipe 18","Instruction 18",18.44),
array(19,"recipe 19","Instruction 19",87.76));

$mockIngredientData = array(array(1,"olives",5.57),
array(2,"chicken",6.58),
array(3,"tomato",5.09),
array(4,"celery",3.52),
array(5,"apple",5.11),
array(6,"flour",9.2),
array(7,"pickle",3.34),
array(8,"almond",2.7),
array(9,"chocolate",6.68),
array(10,"peach",9.5));

$measurements = array("cup", "tbsp", "oz","whole");
array_pop($mockRecipeList);
array_pop($mockIngredientList);
for($index=0; $index <10; $index++){
    $ingredient = new Ingredient();
    $ingredient->id = $mockIngredientData[$index][0];
    $ingredient->name = $mockIngredientData[$index][1];
    $ingredient->qty = $mockIngredientData[$index][2];
    $ingredient->measurement = $measurements[rand(0,3)];
    array_push($mockIngredientList, $ingredient);
}

for($index=0; $index <19; $index++){
    $recipe = new Recipe();
    $recipe->id=$mockRecipeData[$index][0];
    $recipe->name=$mockRecipeData[$index][1];
    $recipe->instruction=$mockRecipeData[$index][2];
    $recipe->set_ingredientList($mockIngredientList);
    $recipe->cookTime=$mockRecipeData[$index][3];
    $recipe->imageURL="Images/emptyIcon.png";
    array_push($mockRecipeList, $recipe);
}

?>