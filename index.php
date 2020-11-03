<?php 
    include "header.php"; 
    include "mockData.php"
?>
<?php
    $currentRecipe = new Recipe();
    $recipe1 = new Recipe();
    $recipe2 = new Recipe();
    $recipe3 = new Recipe();
    $recipe4 = new Recipe();
    $recipe5 = new Recipe();
    $recipe6 = new Recipe();
    $recipe7 = new Recipe();
    

    if(isset($_POST['current'])) {
        $searchedValue = $_POST['current'];
        $currentRecipe = filter_by_value($mockRecipeList, "id", $searchedValue);
    } else {
        $currentRecipe = null;
    }
    if(isset($_POST['one'])) {
        $searchedValue = $_POST['one'];
        $recipe1 = filter_by_value($mockRecipeList, "id", $searchedValue);
    } else {
        $recipe1 = null;
    }
    if(isset($_POST['two'])) {
        $searchedValue = $_POST['two'];
        $recipe2 = filter_by_value($mockRecipeList, "id", $searchedValue);
    } else {
        $recipe2 = null;
    }
    if(isset($_POST['three'])) {
        $searchedValue = $_POST['three'];
        $recipe3 = filter_by_value($mockRecipeList, "id", $searchedValue);array_filter(
            $mockRecipeList,
            function ($e) use ($searchedValue) {
                return $e->id == $searchedValue;
            });
    } else {
        $recipe3 = null;
    }
    if(isset($_POST['four'])) {
        $searchedValue = $_POST['four'];
        $recipe4 = filter_by_value($mockRecipeList, "id", $searchedValue);array_filter(
            $mockRecipeList,
            function ($e) use ($searchedValue) {
                return $e->id == $searchedValue;
            });
    } else {
        $recipe4 = null;
    }
    if(isset($_POST['five'])) {
        $searchedValue = $_POST['five'];
        $recipe5 = filter_by_value($mockRecipeList, "id", $searchedValue);
    } else {
        $recipe5 = null;
    }
    if(isset($_POST['six'])) {
        $searchedValue = $_POST['six'];
        $recipe6 = filter_by_value($mockRecipeList, "id", $searchedValue);
    } else {
        $recipe6 = null;
    }
    if(isset($_POST['seven'])) {
        $searchedValue = $_POST['seven'];
        $recipe7 = filter_by_value($mockRecipeList, "id", $searchedValue);
    } else {
        $recipe7 = null;
    }
    
    $selected = array($recipe1, $recipe2, $recipe3, $recipe4, $recipe5, $recipe6, $recipe7);

    function filter_by_value ($array, $index, $value){
        if(is_array($array) && count($array)>0) 
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                if ($temp[$key] == $value){
                    $newarray[$key] = $array[$key];
                }
            }
          }
      return $newarray[0];
    }

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    //   TODO set up database calls to pull update recipe info
    var instructions = new Map();

    function nextSpot() {
        if( typeof nextSpot.counter == 'undefined' || nextSpot.counter > 6 ) {
            nextSpot.counter = 1;
        } else {
            nextSpot.counter++;
        }
        return nextSpot.counter.toString();
    }
    function updateRecipe(id){
        var current = document.getElementById('current');
        if(current.value == null || current.value == ""){
            document.getElementById('add_btn').hidden = false;
            document.getElementById('edit_link').hidden = false;
        }
        current.value = id;
        document.getElementById('recipeInfo').innerHTML = instructions.get(id);
    }

    function addToList(){
        var number = nextSpot();
        var id = ["one","two","three","four","five","six","seven"];
        var img = "img" + number;
        currentID = document.getElementById('current').value; 
        document.getElementById(id[(number-1)]).value =  currentID
        spot = document.getElementById(img);
        spot.src = document.getElementById(currentID.toString()).src;
        spot.hidden = false;
    }

    function storeInstruction(key, value){
        instructions.set(key.toString(), value);
    }
    // TODO Once database is set up, create a function that reloads the window to get updated POST data
    // TODO Add function that searches the given list (Ajax onKeyChange in the search box -> compare to current recipe list name, ingredients)
    // TODO Add function that sort the list based on given criteria (Ajax onStateChange in dropdown -> make database call to update the list order)

  </script>
<main>
<br/><br/>
    <div>
        <form method="POST" action="list.php">
                <!--TODO: I think we can set these dynamically based on the selected image below. Need to dig a bit more on how to do that with the image selector once we are pulling them from the DB-->
            <table  class="DaysOfWeek">
                <tbody>
                    <tr>
                        <th><?php  echo "Meal 1"; ?></th>
                        <th><?php  echo "Meal 2"; ?></th>
                        <th><?php  echo "Meal 3"; ?></th>
                        <th><?php  echo "Meal 4"; ?></th>
                        <th><?php  echo "Meal 5"; ?></th>
                        <th><?php  echo "Meal 6"; ?></th>
                        <th><?php  echo "Meal 7"; ?></th>
                    </tr>
                    <tr>
                        <?php
                            $ids = array("one","two","three","four","five","six","seven");
                            for($index = 0; $index < 7; $index++){
                                if(!empty($selected[$index])){
                                    $imgNum = $index+1;
                                    $recipe = $selected[$index];
                                    echo('<td><input type="hidden" id="'.$ids[$index].'" name="'.$ids[$index].'" value="'.$selected[$index]->id.'"><"<img class="foodIcon" id="img'.$imgNum.'" src="'.$selected[$index]->imageURL.'" hidden="false"></td>');
                                } else{
                                    $imgNum = $index+1;
                                    echo('<td><input type="hidden" id="'.$ids[$index].'" name="'.$ids[$index].'" value=""><img class="foodIcon" id="img'.$imgNum.'" src="" hidden="true"></td>');
                                }
                            }
                        ?>
                        

                    </tr>
                </tbody>
            </table><br/>
            <center>
                <input type="submit" id="list_btn" value="Get Shopping List">
            </center>
        </form>
    </div>



    <div class="menu"> <!-- TODO: This will eventually need to be some kind of image selector. https://rvera.github.io/image-picker/ Limit Multiple Selects -->
        <div id="howToMakeBox">
            <input type="button" id="add_btn" value="Add to List" onclick="addToList()" hidden=true>
            <div id="recipeInfo">Click a recipe to see more info here</div>
            <a id="edit_link" href='modifyRecipe.php' hidden=true>Edit Recipe</a>

        </div>  
        <div class="searchRecipe">
            <ul>
                <li><input type="text" placeholder="Search.."></li>  <!--TODO: On submit this should search for recipes by name/ingredient-->
                <li>    
                    <select name="sort" id="sort">
                        <option value="" disabled selected>Sort by...</option>
                        <option value="recipe_name">Name</option>
                        <option value="cook_time">Time to Cook</option>
                        <option value="date_added">Date Added</option>
                        <option value="ingredient_count">Total Ingredients</option>
                    </select>
                </li>
            </ul>
        </div>
        <form method="POST" action>
        <div class="row">
        <?php
        // Create an image gallery with 4 columns (responsive to 2 with css)
            $recipeCount = sizeof($mockRecipeList); //total number of recipes
            $maxColumns = 4; // total number of columns
            $minPerColumn =  intdiv($recipeCount,$maxColumns); //how many pictures per column on average Ex: 10 recipes at 3 columns should give us a minumum of 3 per column
            $columnsWithExtraImages = $recipeCount%$maxColumns;
            static $recipeIndex = 0;

            for($index = 0; $index < $maxColumns; $index++){
                $extrasLeft = $columnsWithExtraImages;
                echo('<div class="column">');
                if($extrasLeft > 0){
                    $imagePerColumn = $minPerColumn + 1; 
                } else {
                    $imagePerColumn = $minPerColumn;
                }
                for($i = 0; $i < $imagePerColumn; $i++){
                    if($recipeIndex < $recipeCount){
                        $recipe = $mockRecipeList[$recipeIndex];
                        $image = $recipe->imageURL;
                        $instructions = " ".$recipe->displayRecipe()." ";
                        echo("<img class=\"foodIcon,recipeImg\" id=".$recipe->id." src=".$image." onclick=\"updateRecipe(this.id)\">");
                        echo("<script>storeInstruction(".$recipe->id.",\"".$instructions."\")</script>");
                        $recipeIndex++;
                    }
                }
                $extrasLeft--;
                echo('</div>');    
                }
            ?>
        </div>
        <input type="hidden" id ="current" name="current" value="">
        </form>

</main>

<?php include "footer.php"; ?>