<?php
    if ($result-> num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo '<td><img class="foodIcon" src="Images/'.$row["meal_pic"]' alt=""><br>' .$row["meal_name"]'</td>';
        }
    }
?>





<tr>
    <td><input type='number' name='iQty[]' step='0.01'></td>
    <!-- <td><input type='text' name='iUnit[]'></td>  -->
    <!-- <td><select name='qty' id='qty'><option value='Qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td> -->
    <td><select name='iUnit[]' id='qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>
    <td><input type='text' name='iName[]'></td>   
</tr>


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

    
    //Creating the objects
    $meal1 = new Recipe();
    $meal2 = new Recipe();
    $meal3 = new Recipe();
    $meal4 = new Recipe();
    $meal5 = new Recipe();
    $meal6 = new Recipe();
    $meal7 = new Recipe();


// I was hoping to get this to work with the mock data but it may be easier with the database call
    // function ajax_call(){
    //     cur = document.getElementById('current').value;
    //     _1 = document.getElementById('one').value;
    //     _2 = document.getElementById('two').value;
    //     _3 = document.getElementById('three').value;
    //     _4 = document.getElementById('four').value;
    //     _5 = document.getElementById('five').value;
    //     _6 = document.getElementById('six').value;
    //     _7 = document.getElementById('seven').value;
    //     $.ajax({
    //         type:'post',
    //         data:{current:cur, one:_1,two:_2,three:_3,four:_4, five:_5, six:_6, seven:_7}
    //     });
    //     // location.reload();
    // }





    echo '<main onload="addedToDB()">
    <br /><br />
    <section class="submitForm">
        <h3>Added to DB</h3><br />
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
                    <tr>';
                echo "  <td><input type='number' name='ingredientQty[]'></td>
                        <td><select name='qty' id='qty'><option value='Qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>
                        <td><input type='text' name='ingredientName[]'></td>";   
                echo'</tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table><br>
            <p><button type="button" onclick="addItem();">Add Item</button></p><br><br>
            
            <!-- recipe_instructions -->
            <label for="recipeInstuction"><strong>Instructions for Recipe:</strong></label><br/><br/>
            <textarea id="recipeInstuction" name="recipeInstuction" rows="15" cols="50"></textarea><br/><br/>  
            <p><input type="submit" value="submit" name="submit"></p><br/><br/>
        </form>
        
    </section>';


    else{
        echo '<section class="submitForm">
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
                    <tr>';
                echo "
                        <td><input type='number' name='ingredientQty[]'></td>
                        <td><select name='qty' id='qty'><option value='Qty'><option value='Unit'>Unit</option><option value='cup'>Cup</option><option value='tbsp'>Tbsp</option><option value='tsp'>Tsp</option><option value='oz'>oz</option></select></td>
                        <td><input type='text' name='ingredientName[]'></td>";
        echo '               
                    </tr>
                </thead>
                <tbody id="tbody"></tbody><!-- This is for the dynamic rows -->
            </table><br>
            <p><button type="button" onclick="addItem();">Add Item</button></p><br><br>

            <!-- recipe_instructions -->
            <label for="recipeInstuction"><strong>Instructions for Recipe:</strong></label><br/><br/>
            <textarea id="recipeInstuction" name="recipeInstuction" rows="15" cols="50"></textarea><br/><br/>  
            <p><input type="submit" value="submit" name="submit"></p><br/><br/>
        </form>

    </section>

<br /><br />
</main>';
            
            
    }



    ?>