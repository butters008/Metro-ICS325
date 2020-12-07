<?php 
include "header.php"; 
include "dbCred.php";
require_once "recipe.php";
require_once "ingredient.php";
require_once "Collection.php";
?>

<?php  
    $isEdit = false;
    $recipeID = null;
    $recipeName = "";
    $cookTime ="";
    $imageURL = "";
    $iQty= array();
    $iMeasurement = array();
    $iName = array();
    $instructions = "";
    $ingredients = new Collection();
    $errors = array();

    if(isset($_POST['isEdit'])){
        $isEdit = $_POST['isEdit'];
    }
    if(isset($_POST['recipeID'])){
        $recipeID = (int)$_POST['recipeID'];
    }
    if(isset($_POST['recipeName'])){
        $recipeName = htmlspecialchars($_POST['recipeName']);
    }
    if(isset($_POST['cookTime'])){
        $cookTime = (int)htmlspecialchars($_POST['cookTime']);
    }
    
    if(isset($_POST['imgURL'])){
        $imageURL = $_POST['imgURL'];
    }
    if(isset($_POST['iQty'])){
        $iQty = $_POST['iQty'];
    }
    if(isset($_POST['iMeasurement'])){
        $iMeasurement = $_POST['iMeasurement'];
    }
    if(isset($_POST['iName'])){
        $iName = $_POST['iName'];
    }

    if(isset($_POST['instruction'])){
        $instructions = htmlspecialchars($_POST['instruction']);
        $instructions = trim(preg_replace('/\s\s+/', ' ', $instructions));
    }

    if(sizeof($iName)==sizeof($iMeasurement) && sizeof($iName)==sizeof($iQty)){
        for($i = 0; $i < sizeof($iName); $i++){
            $ingredient = new Ingredient();
            $ingredient->set_name(htmlspecialchars($iName[$i]));
            $ingredient->set_qty($iQty[$i]);
            $ingredient->set_measurement($iMeasurement[$i]);
            $ingredients->addItem($ingredient, $i);
        }
    
        // Database call to make sure all ingredients are in the database
        foreach($ingredients->allValues() as $i){
            $sql = 'INSERT IGNORE INTO ingredient (ingredient_name) VALUES (?)';

            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_iName);
                $param_iName = $i->get_name();

                if(!mysqli_stmt_execute($stmt)){
                    array_push($errors, "Problem adding ingredients.");
                }
            } else {
                array_push($errors, "Problem connecting to database to add ingredients.");
            }
            mysqli_stmt_close($stmt);
        } 
        

        // Database call to add a new recipe or update existing
        $sql = 'INSERT INTO recipe (recipe_id, recipe_name, cook_time, recipe_instructions, recipe_image_url) 
        VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE recipe_id=?, recipe_name=?, cook_time=?, recipe_instructions=?, recipe_image_url=?'; 

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "isissisiss", $param_ID, $param_rName, $param_cookTime, $param_instructions, $param_imageURL,$param_ID,$param_rName, $param_cookTime, $param_instructions, $param_imageURL);
            $param_ID = $recipeID;
            $param_rName = $recipeName;
            $param_cookTime = $cookTime;
            $param_instructions = $instructions;
            $param_imageURL = $imageURL;
            if(mysqli_stmt_execute($stmt)){
                $newID = mysqli_insert_id($link);
            } else {
                array_push($errors, "Problem adding/updating recipe.");
            }
            mysqli_stmt_close($stmt);
        } else {
            array_push($errors, "Problem connecting to database to add/update recipe.");
        }

        // Database call to delete existing recipe/ingredient links
        if($isEdit) {
            $sql = 'DELETE from recipe_ingredient
            WHERE recipe_id = ?';
            if ($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "i", $param_ID);
                $param_ID = $recipeID;
                if(!mysqli_stmt_execute($stmt)){
                    array_push($errors, "Problem removing old ingredients.");
                }
            } else {
                array_push($errors, "Problem connecting to database to remove old ingredients.");
            }
            mysqli_stmt_close($stmt);
        } 

        // Database call to add ingredients to recipe
        foreach($ingredients->allValues() as $i){
            $sql = 'INSERT INTO recipe_ingredient (recipe_id, ingredient_name, measurement_type, measurement_qty)
            VALUES ( ?, ?, ?, ?)';
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "issd", $param_ID, $param_iName, $param_measurement, $param_qty);
                if($isEdit){
                    $param_ID = $recipeID;
                } else {
                    $param_ID = (int)$newID;
                }
                $param_iName = $i->get_name();
                $param_measurement = $i->get_measurement();
                $param_qty = $i->get_qty();
                if(!mysqli_stmt_execute($stmt)){
                    array_push($errors, "Problem updating recipe ingredients.");
                }
            } else {
                array_push($errors, "Problem connecting to database to update recipe ingredients.");
            }
        }
    } else {
        array_push($errors, "Problem with supplied data.");
    }

?>
<main>
    <?php
        if(sizeof($errors) == 0){
            echo('<p>Recipe successfully updated.</p>
            <a href="index.php">Back to Home</a>');
        } else{
            foreach($errors as $e){
                echo('<p>'.$e.'</p>');
            }
            echo('<p>Please try again.</p>
            <a href="modifyRecipe.php>Add a recipe</a>
            <a href="index.php">Back to Home</a>');
        }
        
    ?>

</main>
<?php include "footer.php"; ?>