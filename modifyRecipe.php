<?php include "header.php"; ?>
<!-- TODO implement $_POST data in order to pull existing recipe details -->
<!-- I added an auto increment to the id column (recipe and shopping list) on the database so we don't have to worry about creating a new ID for each added recipe-->
<main>
    <!-- Making a switch here to choose from modifing or adding -->
    <br /><br />
    <section class="submitForm">
        <h3 id="submitTitle">Cookbook Recipe</h3><br />
        <form action="" method="post">  
            
            <!-- Then comes basic information for recipe
                name, description, assigned 1 of three icons that user previous choosen -->
            <label for="recipeName">Name of Recipe:</label><br>
            <input type="text" id="recipeName" name="recipeName"><br><br>

            <label for="cookTime">Cooking Time for Recipe:</label><br>
            <input type="text" id="cookTime" name="cookTime"><br><br>

            <label for="recipeDescription">Description of Recipe:</label><br>
            <input type="text" id="recipeDescription" name="recipeDescription"><br><br>

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
                        <td><select name='qty' id='qty'><option value='Qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='audi'>oz</option></select></td>
                        <td><input type='text' name='ingredientName[]'></td>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
            
            <p><button type="button" onclick="addItem();">Add Item</button></p>
            <br><br>
            <!-- This is where we tell them to make the instructions as to how to make the recipe
            Thinking that this will output to a text file, than we store this locally on the page 
            For now localhost/server, but once we get further developed, we store on website server            
            REASON: We take the textfile and load onto instruction on main page with correct formatting (I believe) - Keith-->
            <!-- We can just store it in a string with $_POST data but we need to account for sql injection and make sure we have form validation -->
            <label for="ingredientInstuction"><strong>Instructions for Recipe:</strong></label><br/>
            <textarea id="ingredientInstuction" name="ingredientInstuction" rows="15" cols="50"></textarea>
            <p><input type="submit" value="submit" name="submit"></p><br/><br/>
        </form>
    </section>

    <br /><br />
</main>
<script>
    function addItem(){
        var html = "<tr>";
            html += "<td><input type='number' name='ingredientQty[]'></td>";
            html += "<td><select name='qty' id='qty'><option value='qty'><option value='unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='audi'>oz</option></select></td>";
            html += "<td><input type='text' name='ingredientName[]'></td>";
            html += "</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>