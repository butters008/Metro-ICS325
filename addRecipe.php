<?php 

include "header.php"; 
include "dbCred.php";
$msg = "";

function ingredientExists($link, $i_name) {
    $sql3 = "SELECT * FROM ingredient WHERE userName = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($link);
    
    if (!mysqli_stmt_prepare($stmt, $sql3)){
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $i_name);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

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

    //https://www.youtube.com/watch?v=JaRq73y5MJk
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if ($fileSize < 500000){
                // $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'Images/'.$fileName;
                move_uploaded_file('$fileTmpName', $fileDestination);
            } else{
                echo "Your file is to big";
            }
        } else {
            echo "There was an error uploading your file";            
        }
    } else{
        echo "You cannot upload files of this type";
    }

    echo $fileName;

    $sql = "INSERT INTO recipe (recipe_name, cook_time, recipe_instructions, recipe_image_url) VALUES ('$recipeName', '$cookTime', '$recipeInstuction', '$fileName');"; 
    mysqli_query($link, $sql);
    $recipe_id = mysqli_insert_id($link);
    echo $recipe_id;

    for ($a = 0; $a < count($_POST["iName"]); $a++){
        $i_qty = $_POST["iQty"][$a];
        $i_unit = $_POST["iUnit"][$a];
        $i_name = $_POST["iName"][$a];

        $sql2 = "INSERT INTO recipe_ingredient (recipe_id, ingredient_name, measurement_type, measurement_qty) VALUES (?, ?, ?, ?);";
        // $sql2 = "INSERT INTO recipe_ingredient (recipe_id, ingredient_name, measurement_type, measurement_qty) VALUES ('$recipe_id', '".$_POST["iName"][$a]."', '".$_POST["iUnit"][$a]."', '".$_POST["iQty"][$a]."');";
        // $sql2 = "INSERT INTO ing (recipe_id, i_amount, i_unit, i_name) VALUES ('$recipe_id', '".$_POST["iQty"][$a]."', '".$_POST["iUnit"][$a]."', '".$_POST["iName"][$a]."');"; 
        // mysqli_query($link, $sql2);
        
        // Prepare the statement
        $stmt = $link->prepare($sql2);
        // var_dump($stmt);
        
        // Bind the parameters    
        $stmt->bind_param('ssss', $p_recipe_id, $p_i_name, $p_i_unit, $p_i_qty);
        $p_recipe_id = $recipe_id;
        $p_i_name = $i_name;
        $p_i_unit = $i_unit;
        $p_i_qty = $i_qty;

        //Execute the statement
        $stmt->execute();
        
        echo "<br>print out everything!";
        echo $i_qty."<br>";
        echo $i_unit."<br>";
        echo $i_name."<br>";
        echo $sql2."<br>";
    }
    echo "<br>You have entered a recipe into the database<br>";   
}
?>
<!-- TODO implement $_POST data in order to pull existing recipe details -->
<!-- I added an auto increment to the id column (recipe and shopping list) on the database so we don't have to worry about creating a new ID for each added recipe-->

<main>
<br /><br />
<section class="submitForm">
    <h3 id="submitTitle">Cookbook Recipe</h3><br />
    <form action="addRecipe.php" method="post" enctype="multipart/form-data">  
        
        <input type="file" id="recipe_image" name="file"><br>

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
                <!-- <tr> -->
                    <!-- <td><input type='number' name='iQty[]' step='0.01'></td> -->
                    <!-- <td><input type='text' name='iUnit[]'></td>  -->
                    <!-- <td><select name='iUnit[]' id='qty'><option value='cup'>cup</option><option value='lb'>lb</option><option value='oz'>oz</option><option value='pinch'>pinch</option><option value='pt'>pt</option><option value='qt'>qt</option><option value='tbsp'>tbsp</option><option value='tsp'>Tsp</option><option value='whole'>whole</option></select></td> -->
                    <!-- <td><input type='text' name='iName[]'></td>    -->
                <!-- </tr> -->
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
            html += "<td><select name='iUnit[]' id='qty'><option value='cup'>cup</option><option value='lb'>lb</option><option value='oz'>oz</option><option value='pinch'>pinch</option><option value='pt'>pt</option><option value='qt'>qt</option><option value='tbsp'>tbsp</option><option value='tsp'>Tsp</option><option value='whole'>whole</option></select></td>";
            html += "<td><input type='text' name='iName[]'></td>";
            html += "</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
    }
</script>
<?php include "footer.php"; ?>