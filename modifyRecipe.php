<?php 

    include "header.php"; 
    include "dbCred.php";

    if(isset($_POST["submit"])){

        //Declaring and assigning variables from form
        $recipeName = $_POST["recipeName"];
        $cookTime = $_POST["cookTime"];
        $recipeInstuction = $_POST["recipeInstuction"];

        //testing - success assigning from form to variables
        echo "$recipeName<br>";
        echo "$cookTime<br>";
        echo "$recipeInstuction<br>";

        
        $sql = "INSERT INTO recipe (recipe_name, cook_time, recipe_instructions) VALUES ($recipeName, $cookTime, $recipeInstuction);"; 
        // mysqli_query($link, $sql);
        
        // Prepare the statement
        $stmt = $link->prepare($sql);
        // Bind the parameters
        $stmt->bind_param('sss', $recipeName, $cookTime, $recipeInstuction);
        //Execute the statement
        $stmt->execute();

        // Bind the results - I dont think I need to use Bind....
        // $stmt->bind_result($rID,$rName,$rCookTime,$rInstructions,$rImage, $iID,$iName,$iMeasureType, $iQty);

        echo "<p>Recipe Added to database</p>";

    }

?>
<!-- TODO implement $_POST data in order to pull existing recipe details -->
<!-- I added an auto increment to the id column (recipe and shopping list) on the database so we don't have to worry about creating a new ID for each added recipe-->
<main>
    <!-- Making a switch here to choose from modifing or adding -->
    <br /><br />
    <section class="submitForm">
        <h3 id="submitTitle">Cookbook Recipe</h3><br />
        <form action="modifyRecipe.php" method="post">  
            
            <label for="recipeName">Name of Recipe:</label><br>
            <input type="text" id="recipeName" name="recipeName"><br><br> <!-- recipe_name -->

            <label for="cookTime">Cooking Time for Recipe:</label><br>
            <input type="text" id="cookTime" name="cookTime"><br><br> <!-- cook_time -->

            <!-- Adding ingredents to recipe, making this an array or table 
            Example taken from: https://www.youtube.com/watch?v=qYbkQpSI9_o -->
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
                        <td><select name='qty' id='qty'><option value='Qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>
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

    <br /><br />
</main>
<script>
    function addItem(){
        var html = "<tr>";
            html += "<td><input type='number' name='ingredientQty[]'></td>";
            html += "<td><select name='qty' id='qty'><option value='qty'><option value='unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>";
            html += "<td><input type='text' name='ingredientName[]'></td>";
            html += "</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>