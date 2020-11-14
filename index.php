<?php
include "header.php";
require_once "dbCred.php";
require_once "Collection.php";
require_once "recipe.php";
require_once "ingredient.php";
?>
<main>
    <br /><br />
    <?php

    $currentRecipe = new Recipe();
    $recipe1 = new Recipe();
    $recipe2 = new Recipe();
    $recipe3 = new Recipe();
    $recipe4 = new Recipe();
    $recipe5 = new Recipe();
    $recipe6 = new Recipe();
    $recipe7 = new Recipe();
    

    if (isset($_POST['current'])) {
        $searchedValue = $_POST['current'];
        $currentRecipe = filter_by_value($recipeArray, "id", $searchedValue);
    } else {
        $currentRecipe = null;
    }
    if (isset($_POST['one'])) {
        $searchedValue = $_POST['one'];
        $recipe1 = filter_by_value($recipeArray, "id", $searchedValue);
    } else {
        $recipe1 = null;
    }
    if (isset($_POST['two'])) {
        $searchedValue = $_POST['two'];
        $recipe2 = filter_by_value($recipeArray, "id", $searchedValue);
    } else {
        $recipe2 = null;
    }
    if (isset($_POST['three'])) {
        $searchedValue = $_POST['three'];
        $recipe3 = filter_by_value($recipeArray, "id", $searchedValue);
        array_filter(
            $recipeArray,
            function ($e) use ($searchedValue) {
                return $e->id == $searchedValue;
            }
        );
    } else {
        $recipe3 = null;
    }
    if (isset($_POST['four'])) {
        $searchedValue = $_POST['four'];
        $recipe4 = filter_by_value($recipeArray, "id", $searchedValue);
        array_filter(
            $recipeArray,
            function ($e) use ($searchedValue) {
                return $e->id == $searchedValue;
            }
        );
    } else {
        $recipe4 = null;
    }
    if (isset($_POST['five'])) {
        $searchedValue = $_POST['five'];
        $recipe5 = filter_by_value($recipeArray, "id", $searchedValue);
    } else {
        $recipe5 = null;
    }
    if (isset($_POST['six'])) {
        $searchedValue = $_POST['six'];
        $recipe6 = filter_by_value($recipeArray, "id", $searchedValue);
    } else {
        $recipe6 = null;
    }
    if (isset($_POST['seven'])) {
        $searchedValue = $_POST['seven'];
        $recipe7 = filter_by_value($recipeArray, "id", $searchedValue);
    } else {
        $recipe7 = null;
    }

    $selected = array($recipe1, $recipe2, $recipe3, $recipe4, $recipe5, $recipe6, $recipe7);

    function filter_by_value($array, $index, $value)
    {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key) {
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value) {
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray[0];
    }
    ?>
    <br /><br />
    <div>
        <form method="POST" action="list.php">
            <table class="DaysOfWeek">
                <tbody>
                    <tr>
                        <th><?php echo "Meal 1"; ?></th>
                        <th><?php echo "Meal 2"; ?></th>
                        <th><?php echo "Meal 3"; ?></th>
                        <th><?php echo "Meal 4"; ?></th>
                        <th><?php echo "Meal 5"; ?></th>
                        <th><?php echo "Meal 6"; ?></th>
                        <th><?php echo "Meal 7"; ?></th>
                    </tr>
                    <tr>
                        <?php
                        $ids = array("one", "two", "three", "four", "five", "six", "seven");
                        for ($index = 0; $index < 7; $index++) {
                            if (!empty($selected[$index])) {
                                $imgNum = $index + 1;
                                $recipe = $selected[$index];
                                echo ('<td><input type="hidden" id="' . $ids[$index] . '" name="' . $ids[$index] . '" value="' . $selected[$index]->id . '"><"<img class="foodIcon" id="img' . $imgNum . '" src="' . $selected[$index]->imageURL . '" hidden="false"></td>');
                            } else {
                                $imgNum = $index + 1;
                                echo ('<td><input type="hidden" id="' . $ids[$index] . '" name="' . $ids[$index] . '" value=""><img class="foodIcon" id="img' . $imgNum . '" src="" hidden="true"></td>');
                            }
                        }
                        ?>


                    </tr>
                </tbody>
            </table><br />
            <center>
                <input type="submit" id="list_btn" value="Get Shopping List">
            </center>
        </form>
    </div>



    <div class="menu">
        <div id="howToMakeBox">
            <input type="button" id="add_btn" value="Add to List" onclick="addToList()" hidden=true>
            <div id="recipeInfo">Click a recipe to see more info here</div>
            <a id="edit_link" href='modifyRecipe.php' hidden=true>Edit Recipe</a>

        </div>
        <div class="searchRecipe">
            <ul>
                <li><input type="text" placeholder="Search.."></li>
                <!--TODO: On submit this should search for recipes by name/ingredient-->
                <li>
                    <select name="sort" id="sort" onchange="setSort(this.value)">
                        <option value="" disabled selected>Sort by...</option>
                        <option value="r.recipe_name">Name</option>
                        <option value="r.cook_time">Time to Cook</option>
                        <option value="r.recipe_id">Newest</option>
                        <option value="r.ingredient_count">Fewer Ingredients</option>
                    </select>
                </li>
            </ul>
        </div>
        <form  method="POST" action>
            <div id="gallery" class="row">
                <?php

                if (isset($_COOKIE['sort'])) {
                    $sort=$_COOKIE['sort'];
                } else {
                    $sort = 'r.recipe_name';
                    }
                
                if(isset($_COOKIE['direction'])){
                    $ascOrDesc = $_COOKIE['direction'];
                } else {
                    $ascOrDesc = 'ASC';
                }
                

                // Check the connection
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }

                // SQL Query
                $sql = 'SELECT r.recipe_id, r.recipe_name, r.cook_time, r.recipe_instructions, r.recipe_image_url, r.ingredient_count,
                i.recipe_id, i.ingredient_name, i.measurement_type, i.measurement_qty
                FROM recipe as r
                JOIN recipe_ingredient as i ON i.recipe_id = r.recipe_id
                ORDER BY '.$sort.' '.$ascOrDesc;  

                // Prepare the statement
                if($stmt = mysqli_prepare($link, $sql)){
                    //Execute the statement
                    if(mysqli_stmt_execute($stmt)){
                        // Bind the results
                        if(mysqli_stmt_bind_result($stmt, $rID, $rName, $rCookTime, $rInstructions, $rImage, $ringredientCount, $iID, $iName, $iMeasureType, $iQty)){
                            $recipeCollection = new Collection();
                            $recipe = new Recipe;
                            $lastRowRecipe = null;
                            $workingRecipe = new Recipe;
            
                            while (mysqli_stmt_fetch($stmt)) {
                                $lRow = &$lastRowRecipe;
                                $wRecipe = &$workingRecipe;
                                $thisRowRecipe = new Recipe();
                                $ingredient = new Ingredient();
                                $thisRowRecipe->set_id($rID);
                                $thisRowRecipe->set_name($rName);
                                $thisRowRecipe->set_cookTime($rCookTime);
                                $thisRowRecipe->set_instruction($rInstructions);
                                $thisRowRecipe->set_imageURL($rImage);
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
                                        $recipeCollection->addItem($wRecipe, $wRecipe->get_id());
                                
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
                            $recipeCollection->addItem($workingRecipe, $workingRecipe->get_id());
            
            
                            // Close DB connection
                            $stmt->close();
                            $link->close();
                            
            
            
                            // Create an image gallery with 4 columns (responsive to 2 with css)
                            $recipeCount = $recipeCollection->length(); //total number of recipes
                            $recipeArray = $recipeCollection->allValues();
                            $maxColumns = 4; // total number of columns
                            $minPerColumn =  floor($recipeCount / $maxColumns); //how many pictures per column on average Ex: 10 recipes at 3 columns should give us a minumum of 3 per column
                            $columnsWithExtraImages = $recipeCount % $maxColumns;
                            static $recipeIndex = 0;
            
                            for ($index = 0; $index < $maxColumns; $index++) {
                                $extrasLeft = $columnsWithExtraImages;
                                echo ('<div class="column">');
                                if ($extrasLeft > 0) {
                                    $imagePerColumn = $minPerColumn + 1;
                                } else {
                                    $imagePerColumn = $minPerColumn;
                                }
                                for ($i = 0; $i < $imagePerColumn; $i++) {
                                    if ($recipeIndex < $recipeCount) {
                                        $recipe = $recipeArray[$recipeIndex];
                                        $image = $recipe->imageURL;
                                        $instructions = " " . $recipe->displayRecipe() . " ";
                                        echo ("<img class=\"foodIcon,recipeImg\" id=\"" . $recipe->id . "\" src=\"Images/" . $image . "\" alt=\"" . $recipe->name . "\" onclick=\"updateRecipe(this.id)\">");
                                        echo ("<script>storeInstruction(" . $recipe->id . ",\"" . $instructions . "\")</script>");
                                        $recipeIndex++;
                                    }
                                }
                                $extrasLeft--;
                                echo ('</div>');
                            }
                        }
                    }
                }
                
                
               


                ?>
            </div>
            <input type="hidden" id="current" name="current" value="">
        </form>


</main>

<?php include "footer.php"; ?>