<?php include "header.php"; ?>

<?php 



    $foodName1 = "Banana Break";
    $foodName2 = "Deer Meat Spicy Jerky";
    $foodName3 = "Spagethi";
    $foodName4 = "That One thing I can't think of";
    $foodName5 = "Quick and Easy";
    $foodName6 = "Names are super confusing!";
?>

<nav>
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
</nav>
<main>
    <div id="menu"> <!-- This will eventually need to be some kind of image selector. https://rvera.github.io/image-picker/ Limit Multiple Selects -->
        <table>
            <tbody>
                <tr>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName1; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName2; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName3; ?></td>
                </tr>
                <tr>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName4; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName5; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName6; ?></td>
                </tr>
                <tr>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName1; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName2; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName3; ?></td>
                </tr>
                <tr>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName4; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName5; ?></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName6; ?></td>
                </tr>
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
    <div id="days">
        <form method="POST" action="list.php">
            <!--I think we can set these dynamically based on the selected image above. Need to dig a bit more on how to do that with the image selector-->
        <table>
            <tbody>
                <tr>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Sunday"; ?>
                    <input type="hidden" id= "1" name="1" value=""/></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Monday"; ?>
                    <input type="hidden" id="2" name="2" value=""/></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Tuesday"; ?>
                    <input type="hidden" id="3" name="3" value=""/></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Wednesday"; ?>
                    <input type="hidden" id= "4" name="4" value=""/></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Thursday"; ?>
                    <input type="hidden" id= "5" name="5" value=""/></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Friday"; ?>
                    <input type="hidden" id= "6" name="6" value=""/></td>
                    <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Saturday"; ?>
                    <input type="hidden" id= "7" name="7" value=""/></td> 
                    <td><input type="submit" id="list_btn" value="Get List"></td>
                </tr>
            </tbody>
        </table>
    </form>
    </div>
</main>

<?php include "footer.php"; ?>