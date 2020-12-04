<?php 

include "header.php"; 
    include "dbCred.php";


//IMPORTNAT - This is only used for local debug, delete once we get it working on server  
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'ics325fa2005');
 
// $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// if($link === false){
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }

// if (!$link->set_charset("utf8")) {
//     printf("Error loading character set utf8: %s\n", $mysqli->error);
//     exit();
// }
//IMPORTNAT - This is only used for local debug, delete once we get it working on server


if(isset($_POST["submit"])){

    //Declaring and assigning variables from form
    $recipeName = $_POST["recipeName"];
    $cookTime = $_POST["cookTime"];
    $recipeInstuction = $_POST["recipeInstuction"];
    
    $sql = "INSERT INTO recipe (recipe_name, cook_time, recipe_instructions) VALUES ('$recipeName', '$cookTime', '$recipeInstuction');"; 
    mysqli_query($link, $sql);
    $recipe_id = mysqli_insert_id($link);

    for ($a = 0; $a < count($_POST["ingredientName"]); $a++){
        $sql = "INSERT INTO recipe (recipe_id, ingredient_amount, ingredient_unit, ingredient_name) VALUES ('$recipe_id', '".$_POST["ingredientQty"][$a]."', '".$_POST["ingredientUnit"][$a]."', '".$_POST["ingredientName"][$a]."',);"; 
        mysqli_query($link, $sql);
    }



    // $sql = "INSERT INTO recipe (recipe_name, cook_time, recipe_instructions) VALUES (?, ?, ?);"; 
    // // mysqli_query($link, $sql);
    
    // // Prepare the statement
    // $stmt = $link->prepare($sql);
    // // Bind the parameters
    // $stmt->bind_param('sss', $recipeName, $cookTime, $recipeInstuction);
    // //Execute the statement
    // $stmt->execute();

    echo "You have entered a recipe into the database";   

}
else if(isset($_GET['recipe_id'])){

    echo "Is this working";

    $id = mysqli_real_escape_string($link, $_GET['recipe_id']);
    
    $sql = "SELECT * FROM recipe WHERE recipe_id = ?;"; 
    // mysqli_query($link, $sql);
    
    // $result = mysqli_query($db, $sql);
    // $recipe = mysqli_fetch_assoc($result);
    // mysqli_free_result($result);
    // mysqli_close($db);

    // Prepare the statement
    $stmt = $link->prepare($sql);
    // Bind the parameters
    $stmt->bind_param('s', $recipe_id);
    //Execute the statement
    $stmt->execute();
    $result = mysqli_query($link, $sql);
    // $recipe = mysqli_fetch_assoc($result);


}



?>
<!-- TODO implement $_POST data in order to pull existing recipe details -->
<!-- I added an auto increment to the id column (recipe and shopping list) on the database so we don't have to worry about creating a new ID for each added recipe-->

<main>
<br /><br />
<section class="submitForm">
    <h3 id="submitTitle">Cookbook Recipe</h3><br />
    <form action="modifyRecipe.php" method="post">  
        
        <label for="recipeName">Name of Recipe:</label><br>
        <input type="text" id="recipeName" name="recipeName"><br><br> <!-- recipe_name -->

        <label for="cookTime">Cooking Time for Recipe:</label><br>
        <input type="text" id="cookTime" name="cookTime"><br><br> <!-- cook_time -->

        <label for="ingredientTable">Ingredients for Recipe:</label><br><br>
        <table id="ingredientTable">
            <thead>
                <tr>
                    <th>Qty: </th>
                    <th>Units:</th>
                    <th>Ingredient Name:</th>
                </tr>
                <tr>
                   <td><input type='number' name='ingredientQty[]'></td>
                   <td><input type='text' name='ingredientUnit[]'></td> 
                   <!-- <td><select name='qty' id='qty'><option value='Qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td> -->
                    <td><input type='text' name='ingredientName[]'></td>   
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table><br>
        <p><button type="button" onclick="addItem();">Add Item</button></p><br><br>
        
        <!-- recipe_instructions -->
        <label for="recipeInstuction"><strong>Instructions for Recipe:</strong></label><br/><br/>
        <textarea id="recipeInstuction" name="recipeInstuction" rows="15" cols="50"></textarea><br/><br/>  
        <p><input type="submit" value="submit" name="submit"></p><br/><br/>
    </form>
    
</section>

                
<script>
    function addedToDB() {
        alert("Added recipe to DB!");
    }

    function addItem(){
        var html = "<tr>";
            html += "<td><input type='number' name='ingredientQty[]'></td>";
            html += "<td><input type='text' name='ingredientUnit[]'></td>";
            //html += "<td><select name='qty' id='qty'><option value='qty'><option value='unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>";
            html += "<td><input type='text' name='ingredientName[]'></td>";
            html += "</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>