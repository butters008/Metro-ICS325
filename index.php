<?php 
    include "header.php"; 
?>


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
            <center>
                <input type="submit" id="list_btn" value="Get Shopping List">
            </center>
        </form>
    </div>



    <div class="menu"> <!-- TODO: This will eventually need to be some kind of image selector. https://rvera.github.io/image-picker/ Limit Multiple Selects -->
        <div id="howToMakeBox">
            <input type="button" id="add_btn" value="Add to List">   
            <p>Placeholder for recipe name</p>
            <p>Placeholder for recipe ingredients</p>
            <p>Placeholder for recipe instructions</p>
            <a href='recipe.php'>Edit Recipe</a>

        </div>  
        <div class="searchRecipe">
            <ul>
                <li><input type="text" placeholder="Search.."></li>  <!--TODO: On submit this should search for recipes by name/ingredient-->
                <li>    
                    <select name="sort" id="sort">
                        <option value="" disabled selected>Sort by...</option>
                        <option value="recipe_name">Recipe</option>
                        <option value="cook_time">Time to Cook</option>
                        <option value="date_added">Date Added</option>
                        <option value="ingredient_count">Less Ingredients</option>
                    </select>
                </li>
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