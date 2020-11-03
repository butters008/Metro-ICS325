<?php include "header.php"; ?>

<main>
<br />
    <div id="choose">
        <ul>
            <li><a href="recipe.php" class="active">Add Recipe</a></li>
            <li><a href="modifyRecipe.php">Modify Recipe</a></li>
        </ul>
    </div>
    
    <!-- Making a switch here to choose from modifing or adding -->
    <br /><br />
    <section class="submitForm">
        <h3 id="submitTitle">Submit a recipe for Cookbook</h3>
        <form action="" method="post">  
            <!--(Thought process for menu decission was from Applebees) 
                Make them choose: dinner -  dessert/snack -  appatizer -->
            
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
            <table id="ingredientTable">
                <thead>
                    <tr>
                        <th>Ingredent Name: </th>
                        <th>Amount: </th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
            
            <p><button type="button" onclick="addItem();">Add Item</button></p>
            <!-- This is where we tell them to make the instructions as to how to make the recipe
            Thinking that this will output to a text file, than we store this locally on the page 
            For now localhost/server, but once we get further developed, we store on website server            
            REASON: We take the textfile and load onto instruction on main page with correct formatting (I believe) -->
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
            html += "<td><input name='ingredentName[]'></td>";
            html += "<td><input name='ingredentAmount[]'></td>";
            html += "</tr>";

            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>
