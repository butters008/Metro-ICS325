<?php
include "header.php";
require_once "dbCred.php";
require_once "Collection.php";
require_once "recipe.php";
require_once "ingredient.php";
?>
<main>
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
                        // Create box for selecting meals
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

            <a id="edit_link" href='"modifyRecipe.php' hidden=true><input type="button" value= "Edit Recipe"/></a> 

        </div>
        <div class="searchRecipe">
            <ul>
                <li><input id="search" type="text" placeholder="Search..." onkeyup="search(this.value)"></li>
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
        <form  id="gallery" method="POST" action>
            <div class="row">
                <?php
                if (isset($_COOKIE['sort'])) {
                    $sort=$_COOKIE['sort'];
                    unset($_COOKIE['sort']);
                    setcookie('sort', "", time() - 3600);
                } else {
                    $sort = 'r.recipe_name';
                    }
                
                if(isset($_COOKIE['direction'])){
                    $ascOrDesc = $_COOKIE['direction'];
                    unset($_COOKIE['direction']);
                    setcookie('direction', "", time() - 3600);
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
                            $workingRecipe = new Recipe;
                            $i_counter = 1;
                            
                            while (mysqli_stmt_fetch($stmt)) {
                                $wRecipe = &$workingRecipe;
                                $thisRowRecipe = new Recipe();
                                $ingredient = new Ingredient();
                                $thisRowRecipe->set_id($rID);
                                $thisRowRecipe->set_name($rName);
                                $thisRowRecipe->set_cookTime($rCookTime);
                                $thisRowRecipe->set_instruction($rInstructions);
                                $thisRowRecipe->set_imageURL($rImage);
                                $thisRowRecipe->set_ingredientCount($ringredientCount);
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
                                    $recipeCollection->addItem($wRecipe, $wRecipe->get_id());
                                    $ic = 1;
                                } else if ($thisRowRecipe->get_id() == $wRecipe->get_id()){
                                    // Otherwise add the remaining ingredients
                                    $wRecipe->addIngredient($ingredient);
                                    $ic++;
                                }   
                            }
            
                            // Close DB connection
                            $stmt->close();
                            $link->close();
                          
                            // If user is searching, filter values
                            if(isset($_COOKIE['search'])){
                                $search = $_COOKIE['search'];
                                unset($_COOKIE['search']);
                                setcookie('search', "", time() - 3600);
                            } else {
                                $search = null;
                            }

                            // Make sure we get at least one picture per column
                            function getMinPerColumn($count, $max){
                                $min = floor($count / $max);
                                if($min == 0){ return 1;}
                                return $min;
                            }
                            function getColumnsWithExtraImages($count, $max){
                                if($count < $max){ return 0;}
                                return $count % $max;
                            }

                            // Create an image gallery with 4 columns (responsive to 2 with css)
                            $recipeArray = array_filter($recipeCollection->filter($search, ["name","ingredientList"],"name"));
                            $recipeCount = sizeof($recipeArray); //total number of recipes
                            $maxColumns = 4; // total number of columns
                            $minPerColumn =  getMinPerColumn($recipeCount, $maxColumns); //how many pictures per column on average Ex: 10 recipes at 3 columns should give us a minumum of 3 per column
                            $columnsWithExtraImages = getColumnsWithExtraImages($recipeCount,$maxColumns);
                        
                            if($recipeCount == 0){
                                echo('<h3>Sorry, there are no recipes that match your search.</h3>
                                <h4>Try searching by recipe name or ingredient.</h4>');
                            }

                            for ($index = 0; $index < $maxColumns; $index++) {
                                $extrasLeft = $columnsWithExtraImages;
                                echo ('<div class="column">');
                                if ($extrasLeft > 0) {
                                    $imagePerColumn = $minPerColumn + 1;
                                } else {
                                    $imagePerColumn = $minPerColumn;
                                }
                                for ($i = 0; $i < $imagePerColumn; $i++) {
                                    $recipe = array_shift($recipeArray);
                                    if($recipe instanceof Recipe){
                                        $image = $recipe->imageURL;
                                        $instructions = " " . $recipe->displayRecipe() . " ";
                                        if($image == null || $image == ""){
                                            $image = 'emptyIcon.png';
                                        }
                                        echo ("<img class=\"foodIcon,recipeImg\" id=\"" . $recipe->id . "\" src=\"Images/" . $image . "\" alt=\"" . $recipe->name . "\" onclick=\"updateRecipe(this.id)\">");
                                        echo ("<script>storeInstruction(\"" . $recipe->id . "\",\"" . $instructions . "\")</script>");
                                    }
                                }
                                $extrasLeft--;
                                echo ('</div>');

                            }
                        }
                        echo('<div id="recs">');
                    }   
                                   
                }
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
        
                ?>
            </div>
            <input type="hidden" id="current" name="current" value="">
        </form>


</main>

<?php include "footer.php"; ?>