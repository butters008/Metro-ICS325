<?php 

include "header.php"; 
include "dbCred.php";

//IMPORTNAT - This is only used for local debug, delete once we get it working on server  
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'ics325fa2005');

// global $id;

// $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// if($link === false){
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }

// if (!$link->set_charset("utf8")) {
//     printf("Error loading character set utf8: %s\n", $mysqli->error);
//     exit();
// }
//IMPORTNAT - This is only used for local debug, delete once we get it working on server

// if(isset($_POST["submit"])){
//     $id = $_POST["recipe_id"];
//     $sql = "SELECT * FROM recipe WHERE recipe_id = $id;"; 
//     // mysqli_query($link, $sql);
    
//     $result = mysqli_query($link, $sql);
//     $recipe = mysqli_fetch_assoc($result);
//     mysqli_free_result($result);
//     mysqli_close($link);

// }


if(isset($_GET['recipe_id'])){

    echo "Is this working";

    $id = mysqli_real_escape_string($link, $_GET['recipe_id']);

    $sql = "SELECT * FROM recipe WHERE recipe_id = $id;"; 
    // mysqli_query($link, $sql);

    $ingredient = "SELECT * FROM recipe_ingredient WHERE recipe_id = $id;"; 
    $result = mysql_query($link, $ingredient);

    $result = mysqli_query($link, $sql);
    $recipe = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($link);

    echo "The id is: ";
    echo $id."<br>";
    echo "The sql is: ";
    echo $sql."<br>";
 
}

?>

<!-- TODO implement $_POST data in order to pull existing recipe details -->
<!-- I added an auto increment to the id column (recipe and shopping list) on the database so we don't have to worry about creating a new ID for each added recipe-->
<main>
<br /><br />
<section class="submitForm">
    <form action="modifyRecipe.php?recipe_id=">
        <label for="recipeID">Pull up recipe by ID:</label><br>
        <input type="text" id="recipeID" name="recipe_id" value="<?php echo $recipe['recipe_id'];?>"><br><br>
    </form>

    <h3 id="submitTitle">Cookbook Recipe</h3><br />
    <form action="modifyRecipe.php" method="post">  

        <?php echo "<img src='Images/".$recipe["recipe_image_url"]."'style='max-width: 200px; max-height: 200px;'>";?><br><br>
        
        <label for="recipeName">Name of Recipe:</label><br>
        <input type="text" id="recipeName" name="recipeName" value="<?php echo $recipe['recipe_name'];?>"><br><br> <!-- recipe_name -->

        <label for="cookTime">Cooking Time for Recipe:</label><br>
        <input type="text" id="cookTime" name="cookTime" value="<?php echo $recipe['cook_time'];?>"><br><br> <!-- cook_time -->

        <label for="ingredientTable">Ingredients for Recipe:</label><br><br>
        <table id="ingredientTable">
            <thead>
                <tr>
                    <th>Qty: </th>
                    <th>Units:</th>
                    <th>Ingredient Name:</th>
                </tr>
<?php 

//https://stackoverflow.com/questions/15251095/display-data-from-sql-database-into-php-html-table#


while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
    echo "<tr><td>" . $row['measurement_qty'] . "</td><td>" . $row['measurement_type'] . "</td><td>" . $row['ingredient_name'] . "</td></tr>";  //$row['index'] the index here is a field name
}

?>
            </thead>
            <tbody id="tbody"></tbody>
        </table><br>
        <p><button type="button" onclick="addItem();">Add Item</button></p><br><br>
        
        <!-- recipe_instructions -->
        <label for="recipeInstuction"><strong>Instructions for Recipe:</strong></label><br/><br/>
        <textarea id="recipeInstuction" name="recipeInstuction" rows="15" cols="50" ><?php echo $recipe['recipe_instructions']?></textarea><br/><br/>  
        <p><input type="submit" value="submit" name="submit"></p><br/><br/>
    </form>
    
</section>
</main>
                
<script>
    function addedToDB() {
        alert("Added recipe to DB!");
    }

    function addItem(){
        var html = "<tr>";
            html += "<td><input type='number' step='0.01' name='iQty[]'></td>";
            // html += "<td><input type='text' name='iUnit[]'></td>";
            html += "<td><select name='iUnit[]' id='qty'><option value='qty'><option value='unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>";
            html += "<td><input type='text' name='iName[]'></td>";
            html += "</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>