<?php 

include "header.php"; 
include "dbCred.php";

if(isset($_POST["submit"])){

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
        

    //Declaring and assigning variables from form
    $recipeName = $_POST["recipeName"];
    $cookTime = $_POST["cookTime"];
    $recipeInstuction = $_POST["recipeInstuction"];
    
    $sql = "INSERT INTO recipe (recipe_name, cook_time, recipe_instructions) VALUES ('$recipeName', '$cookTime', '$recipeInstuction');"; 
    mysqli_query($link, $sql);
    $recipe_id = mysqli_insert_id($link);
    echo $recipe_id;

    for ($a = 0; $a < count($_POST["iName"]); $a++){
        $sql2 = "INSERT INTO recipe_ingredient (recipe_id, ingredient_name, measurement_type, measurement_qty) VALUES ('$recipe_id', '".$_POST["iName"][$a]."', '".$_POST["iUnit"][$a]."', '".$_POST["iQty"][$a]."');";
        // $sql2 = "INSERT INTO ing (recipe_id, i_amount, i_unit, i_name) VALUES ('$recipe_id', '".$_POST["iQty"][$a]."', '".$_POST["iUnit"][$a]."', '".$_POST["iName"][$a]."');"; 
        mysqli_query($link, $sql2);
        echo "<br>print out everything!";
        echo $_POST["iQty"][$a]."<br>";
        echo $_POST["iUnit"][$a]."<br>";
        echo $_POST["iName"][$a]."<br>";
        echo $sql2."<br>";
    }



    // $sql = "INSERT INTO recipe (recipe_name, cook_time, recipe_instructions) VALUES (?, ?, ?);"; 
    // // mysqli_query($link, $sql);
    
    // // Prepare the statement
    // $stmt = $link->prepare($sql);
    // // Bind the parameters
    // $stmt->bind_param('sss', $recipeName, $cookTime, $recipeInstuction);
    // //Execute the statement
    // $stmt->execute();

    echo "<br>You have entered a recipe into the database";   

}




?>
<!-- TODO implement $_POST data in order to pull existing recipe details -->
<!-- I added an auto increment to the id column (recipe and shopping list) on the database so we don't have to worry about creating a new ID for each added recipe-->

<main>
<br /><br />
<section class="submitForm">
    <h3 id="submitTitle">Cookbook Recipe</h3><br />
    <form action="addRecipe.php" method="post">  
        
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
                    <td><input type='number' name='iQty[]' step='0.01'></td>
                    <!-- <td><input type='text' name='iUnit[]'></td>  -->
                    <td><select name='iUnit[]' id='qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>
                    <td><input type='text' name='iName[]'></td>   
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
</main>
                
<script>
    function addedToDB() {
        alert("Added recipe to DB!");
    }

    function addItem(){
        var html = "<tr>";
            html += "<td><input type='number' step='0.01' name='iQty[]'></td>";
            html += "<td><select name='iUnit[]' id='qty'><option value='qty'><option value='unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>";
            html += "<td><input type='text' name='iName[]'></td>";
            html += "</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>