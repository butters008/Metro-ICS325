<?php 
    include "header.php"; 
?>

<?php
    // class Ingredient {
    //     public $ingredientName;
    //     public $ingredentAmount;

    //     function set_ingredientName($ingredientName) {
    //         $this->ingredientName = $ingredientName;
    //     }
    //     function get_ingredientName(){
    //         return $this->$ingredientName;
    //     }
    // }

    class Recipe {
        //Properties
        public $mealName;
        public $instruction;
        public $ingredientName;
        public $ingredentAmount;

        //Constuctors
        function set_mealName($mealName){
            $this->mealName = $mealName;
        }
        function get_mealName(){
            return $this->mealName;
        }
        function set_ingredientName($ingredientName) {
            $this->ingredientName = $ingredientName;
        }
        function get_ingredientName(){
            return $this->$ingredientName;
        }
        function set_ingredientAmount($ingredientAmount) {
            $this->ingredientAmount = $ingredientAmount;
        }
        function get_ingredientAmount(){
            return $this->$ingredientAmount;
        }
        function set_instruction($instruction){
            $this->instruction = $instruction;
        }
        function get_instruction(){
            return $this->instruction;
        }
    }

    //Creating the objects
    $meal1 = new Recipe();
    $meal2 = new Recipe();
    $meal3 = new Recipe();
    $meal4 = new Recipe();
    $meal5 = new Recipe();
    $meal6 = new Recipe();
    $meal7 = new Recipe();
?>

<main>
<br/><br/>
    <div>
        <form method="POST" action="list.php">
                <!--I think we can set these dynamically based on the selected image above. Need to dig a bit more on how to do that with the image selector-->
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
                        <td id="1" name="1" value=""></td>
                        <td id="2" name="2" value=""></td>
                        <td id="3" name="3" value=""></td>
                        <td id="4" name="4" value=""></td>
                        <td id="5" name="5" value=""></td>
                        <td id="6" name="6" value=""></td>
                        <td id="7" name="7" value=""></td>
                    </tr>
                </tbody>
            </table><br/>
            <center> <!-- TODO: Going to have to change, just doing this for right now -->
            <input style="margin: auto;" type="submit" id="list_btn" value="Print Current List">
            </center>
        </form>
    </div>



    <div class="menu"> <!-- This will eventually need to be some kind of image selector. https://rvera.github.io/image-picker/ Limit Multiple Selects -->
        <div id="howToMakeBox">
            this should be working! Can we add an edit button within the recipe?
            Recipe Name
            Cook Time ?? <-Could add this option to the database
            Ingredients
            Instructions
        </div>  
        <div class="searchRecipe">
            <ul>
                <li><input type="text" placeholder="Search.."></li>
                <li>    
                    <select name="sort" id="sort">
                        <option value="" disabled selected>Sort by...</option>
                        <option value="recipe_name">Recipe</option>
                        <option value="date_added">Date Added</option>
                        <option value="ingredient_count">Fewer Ingredients</option>
                    </select>
                </li>
                <li><a href='index.php'>Search</a></li>
                <li><a href='index.php'>Add to List</a></li>
            </ul>
        </div>
        
        <table>
            <tbody>
                <tr>

            </tbody>
        </table>
        
    </div>

</main>

<?php include "footer.php"; ?>