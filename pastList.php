<?php include "header.php";
require_once "Collection.php";
require_once "dbCred.php"; 
require_once "recipe.php";
require_once "ingredient.php";
?>
<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$listID = $_REQUEST['sli'];
$recipeCollection = new Collection;


// Check the connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$sql = 'SELECT shopping_list.shopping_list_date, s.recipe_id, r.recipe_name, r.ingredient_count, i.ingredient_name,i.measurement_type, i.measurement_qty
        FROM shopping_list
        JOIN shopping_list_recipe as s on shopping_list.shopping_list_id = s.shopping_list_id
        JOIN recipe as r on s.recipe_id = r.recipe_id
        JOIN recipe_ingredient as i on r.recipe_id = i.recipe_id
        WHERE shopping_list.shopping_list_id = ?
        ORDER BY r.recipe_id';

// Prepare the statement
if($stmt = mysqli_prepare($link, $sql)){
    //Bind parameters
    if(mysqli_stmt_bind_param($stmt, "s", $param_list_id)){
        // Set parameters
        $param_list_id = $listID;
        //Execute the statement
    if(mysqli_stmt_execute($stmt)){ 
        // Bind the results
        if(mysqli_stmt_bind_result($stmt, $list_date, $rID, $rName, $ringredientCount, $iName, $iMeasureType, $iQty)){
            $collection = &$recipeCollection;
            $workingRecipe = new Recipe;
            $i_counter = 1;
            $r_counter = 1;
            
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
                $rc = &$r_counter;
                
                // First row of new recipe
                if ($ic == 1){
                    $wRecipe = $thisRowRecipe;
                }
                // If this is the last ingredient in the set add it to the recipe and the recipe to the collection collection and reset ingredient count
                if ($ringredientCount <= $ic){
                    $wRecipe->addIngredient($ingredient);
                    $collection->addItem($wRecipe, $rc);
                    $ic = 1;
                    $rc++;
                } else if ($thisRowRecipe->get_id() == $wRecipe->get_id()){
                    // Otherwise add the remaining ingredients
                    $wRecipe->addIngredient($ingredient);
                    $ic++;
                } 
            }

        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($link);

$list_date = new DateTime($list_date);
$prettyDate = $list_date->format("m-d-Y h:i");
}
    
?>
<main>
    <div id="list">
    <h2>Shopping List:</h2>
    <p>Originally Generated: <?php echo($prettyDate)?></p>
    <?php
        foreach($recipeCollection->allValues() as $recipe){
            echo('<h2>'.$recipe->name.'</h2>');
            echo($recipe->displayIngredients());
        }
    ?>
    </div>
    <input type="button" onclick="printList();" value= "Print">
</main>

<?php include "footer.php"; ?>
