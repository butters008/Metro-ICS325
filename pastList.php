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

$sql = 'SELECT shopping_list.shopping_list_date, s.recipe_id, r.recipe_name, i.ingredient_name,i.measurement_type, i.measurement_qty
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
        if(mysqli_stmt_bind_result($stmt, $list_date, $rID, $rName, $iName, $iMeasureType, $iQty)){
            $collection = &$recipeCollection;
            $lastRowRecipe = null;
            $workingRecipe = new Recipe;
            
            while (mysqli_stmt_fetch($stmt)) {
                $lRow = &$lastRowRecipe;
                $wRecipe = &$workingRecipe;
                $thisRowRecipe = new Recipe();
                $ingredient = new Ingredient();
                $thisRowRecipe->set_id($rID);
                $thisRowRecipe->set_name($rName);
                $ingredient->set_name($iName);
                $ingredient->set_measurement($iMeasureType);
                $ingredient->set_qty($iQty);
            
                
                // If this row belongs to the same recipe, just add the ingredient 
                if ($lRow != null) {
                    if ($thisRowRecipe->get_id() == $lRow->get_id()) {
                        $wRecipe->addIngredient($ingredient);
                        $lRow = $thisRowRecipe;
                    } else {
                        // This is a new recipe. We need to add the old recipe data to the collection now that all the ingredients are added
                        $collection->addItem($wRecipe, $wRecipe->get_id());
                        // Set the current working recipe to the recipe in this row
                        $wRecipe = $thisRowRecipe;
                        $wRecipe->addIngredient($ingredient);
                        $lRow = $thisRowRecipe;
                    }
                } else {
                    // This is the first time through
                    $wRecipe = $thisRowRecipe;
                    $wRecipe->addIngredient($ingredient);
                    $lRow = $thisRowRecipe;
                }
            }
            // Add the last recipe to the collection
            $collection->addItem($workingRecipe, $workingRecipe->get_id());
            }
             // Close statement
             mysqli_stmt_close($stmt);
        }
    }
            // Close connection
            mysqli_close($link);

            $list_date = new DateTime($list_date);
            $prettyDate = $list_date->format("m-d-Y h:i a");
}
    

?>
<main>
    <h2>Shopping List:</h2>
    <p>Originally Generated: <?php echo($prettyDate)?></p>
    <?php
        foreach($recipeCollection->allValues() as $recipe){
            echo('<h2>'.$recipe->name.'</h2>');
            echo($recipe->displayIngredients());
        }
    ?>
    
</main>

<?php include "footer.php"; ?>
