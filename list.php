<?php include "header.php";
require_once "Collection.php";
require_once "dbCred.php"; 
require_once "recipe.php";
require_once "ingredient.php";
?>
<?php

// Initialize the session
session_start();

// ****Variables
$datetime = new DateTime('now', new DateTimeZone('CST'));
$list_date = $datetime->format("Y-m-d h:i");
$display_date = date("m-d-Y");
$ids = getRecipeIDs();
$loggedIn = isset($_SESSION["loggedin"]) && isset($_SESSION["email"]); 
$recipeCollection = new Collection;
$list_id = 0;
// ****Functions 

//Get the recipe IDs from the post data    
function getRecipeIDs(){
    $labels = array('one','two','three','four','five','six','seven');
    $output = array();
    array_pop($output);
    foreach($labels as $label){
        if(isset($_POST[$label])){
            array_push($output, $_POST[$label]);
        }
    }
    return $output;
}

function getRecipeIDValues($date, $ids){
    $user = $_SESSION['email'];
    $values = "";
    foreach(array_filter($ids) as $id){
        $values = $values.'((SELECT shopping_list_id FROM shopping_list WHERE shopping_list_date=\''.$date.'\' and user_email=\''.$user.'\'), '.$id.'),';
    }
    return substr($values,0,-1) ;
}
function whereString($ids){
    $size = sizeof(array_filter($ids));
    $output = '?';
    for($i=1; $i<$size; $i++){
        $output .= ' or ?';
    }
    return ($output .= ';');
}

    
// Check the connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// SQL Query to get all recipes
$sql = 'SELECT r.recipe_id, r.recipe_name, r.ingredient_count, i.recipe_id, i.ingredient_name, i.measurement_type, i.measurement_qty
FROM recipe as r
JOIN recipe_ingredient as i ON i.recipe_id = r.recipe_id
ORDER BY r.recipe_id';


// Prepare the statement
if($stmt = mysqli_prepare($link, $sql)){
    //Execute the statement
    if(mysqli_stmt_execute($stmt)){
        // Bind the results
        if(mysqli_stmt_bind_result($stmt, $rID, $rName, $ringredientCount, $iID, $iName, $iMeasureType, $iQty)){
            $collection = &$recipeCollection;
            $workingRecipe = new Recipe;
            $i_counter = 1;

            while (mysqli_stmt_fetch($stmt)) {
                $wRecipe = &$workingRecipe;
                $thisRowRecipe = new Recipe();
                $ingredient = new Ingredient();
                $thisRowRecipe->set_id($rID);
                $thisRowRecipe->set_name($rName);
                $ingredient->set_name($iName);
                $ingredient->set_measurement($iMeasureType);
                $ingredient->set_qty($iQty);
                $ic = &$i_counter;
            

                // First row of new recipe
                if ($ic == 1){
                    $wRecipe = $thisRowRecipe;
                }
                // If this is the last ingredient in the set add it to the recipe and the recipe to the collection collection and reset ingredient count
                if ($ringredientCount <= $ic){
                    $wRecipe->addIngredient($ingredient);
                    $collection->addItem($wRecipe, $wRecipe->get_id());
                    $ic = 1;
                } else if ($thisRowRecipe->get_id() == $wRecipe->get_id()){
                    // Otherwise add the remaining ingredients
                    $wRecipe->addIngredient($ingredient);
                    $ic++;
                }  
            }
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

        
    
$shoppingListCollecion = new Collection;
$shoppingListCollecion = getSelectedRecipes($recipeCollection, $ids);

function getSelectedRecipes($collection, $ids){
    $col = new Collection;
    $index =0;
    foreach(array_filter($ids) as $id){
        $col->addItem($collection->getItem($id), $index);
        $index++;
    }
    return $col;
}

// Store the details if the user is logged in
if($loggedIn){
    $sql = 'INSERT into shopping_list (shopping_list_date, user_email) values ( ?, ? )';
    // Prepare the statement
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        if(mysqli_stmt_bind_param($stmt, "ss", $param_list_date, $param_email)){
            // Set paramenter
            $param_list_date = $list_date;
            $param_email = $_SESSION['email'];
            //Execute the statement
            if(mysqli_stmt_execute($stmt)){
                $last_id = mysqli_insert_id($link);
                $list_id =$last_id;
                // Close statement
                mysqli_stmt_close($stmt);
            }             
        }        
    }
    $meal_count = 0;
    foreach($shoppingListCollecion->allValues() as $recipe){
        $mc = &$meal_count;
        $numbers = array('one','two','three','four','five','six','seven');
        $sql = 'INSERT into shopping_list_recipe (shopping_list_id, recipe_id, meal_number) values (?,?,?)';
        // Prepare the statement
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            if(mysqli_stmt_bind_param($stmt, "sss", $param_list_id, $param_recipe, $param_meal_num)){
                // Set paramenter
                $param_list_id = $list_id;
                $param_recipe =  $recipe->get_id();
                $param_meal_num =$numbers[$mc];
                //Execute the statement
                if(mysqli_stmt_execute($stmt)){
                    $last_id = mysqli_insert_id($link);
                    // Close statement
                    mysqli_stmt_close($stmt);
                }             
            }   
        }
        $mc++;
    }

    // Close connection
    mysqli_close($link);
}

?>

<main>
    <h2>Shopping List:</h2>
    <p>Generated <?php echo($list_date)?></p>
    <?php
        foreach($shoppingListCollecion->allValues() as $recipe){
            echo('<h2>'.$recipe->name.'</h2>');
            echo($recipe->displayIngredients());
        }
    ?>
    
</main>

<?php include "footer.php"; ?>