<?php 
    include "header.php"; 
?>

<?php 
    class MealForDay {
        //Properties
        public $nameOfDay;
        public $mealName;
        public $ingredentName;

        function set_nameOfDay($nameOfDay){
            $this->nameOfDay = $nameOfDay;
        }
        function get_nameOfDay(){
            return $this->nameOfDay;
        }

    }
?>

<main>
<br/><br/>
    <div>
        <form method="POST" action="list.php">
                <!--I think we can set these dynamically based on the selected image above. Need to dig a bit more on how to do that with the image selector-->
            <table  class="DaysOfWeek">
                <tbody>
                    <tr>
                        <th><?php  echo "Sunday"; ?></th>
                        <th><?php  echo "Monday"; ?></th>
                        <th><?php  echo "Tuesday"; ?></th>
                        <th><?php  echo "Wednesday"; ?></th>
                        <th><?php  echo "Thursday"; ?></th>
                        <th><?php  echo "Friday"; ?></th>
                        <th><?php  echo "Saturday"; ?></th>
                        <th><input type="submit" id="list_btn" value="Get List"></th>
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
            </table>
        </form>
    </div>



    <div id="menu"> <!-- This will eventually need to be some kind of image selector. https://rvera.github.io/image-picker/ Limit Multiple Selects -->
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
                <li><li><a href='index.php'>Add a Recipe</a></li></li>
            </ul>
        </div>
        
        <table>
            <tbody>
                <tr>

            </tbody>
        </table>
    </div>
    <div id="howToMakeBox">
        this should be working! Can we add an edit button within the recipe?
        Recipe Name
        Cook Time ?? <-Could add this option to the database
        Ingredients
        Instructions
    </div>
</main>

<?php include "footer.php"; ?>