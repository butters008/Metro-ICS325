<?php 
include "header.php"; 
include "dbCred.php";
require_once "recipe.php";
require_once "ingredient.php";
require_once "Collection.php";
?>

<?php
$recipe = new Recipe();
$ingredients = new Collection();
$isEdit = isset($_GET['recipe_id']);
$hasNewImg = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{   

  if (is_uploaded_file($_FILES['img']['tmp_name'])) 
  { 

  	//First, Validate the file name
  	if(empty($_FILES['img']['name']))
  	{
  		echo " File name is empty! ";
  		exit;
      }


  	$upload_file_name = $_FILES['img']['name'];
  	//Too long file name?
  	if(strlen ($upload_file_name)>100)
  	{
  		echo " too long file name ";
  		exit;
    }


  	//replace any non-alpha-numeric characters in th file name
  	$upload_file_name = preg_replace("/[^A-Za-z0-9 \.\-_]/", '', $upload_file_name);
  	//set a limit to the file upload size
  	if ($_FILES['img']['size'] > 1000000) 
  	{
		echo " too big file ";
  		exit;        
    }

    //Save the file
    $dest=__DIR__.'/Images/'.$upload_file_name;
 
    $hasNewImg = move_uploaded_file($_FILES['img']['tmp_name'], $dest);
  }
  
}

if($isEdit){
    $_POST['isEdit'] = $isEdit;
    $id = mysqli_real_escape_string($link, $_GET['recipe_id']);
    $sql = "SELECT r.recipe_id, r.recipe_name, r.cook_time, r.recipe_instructions, r.recipe_image_url, r.ingredient_count,
    i.recipe_id, i.ingredient_name, i.measurement_type, i.measurement_qty
    FROM recipe as r
    JOIN recipe_ingredient as i ON i.recipe_id = r.recipe_id
    WHERE r.recipe_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_id);
        $param_id = $id;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
        }
        if(mysqli_stmt_num_rows($stmt) > 0){
            mysqli_stmt_bind_result($stmt, $rID, $rName, $rCooktime, $rInstructions, $rImageUrl, $rIngredientCount, $iId, $iIngredientName, $iMeasurement, $iQty);
            $index = 1;
            while(mysqli_stmt_fetch($stmt)){
                if($index == 1){
                    $recipe->set_id($rID);
                    $recipe->set_name($rName);
                    $recipe->set_cookTime($rCooktime);
                    $recipe->set_instruction($rInstructions);
                    $recipe->set_imageURL($rImageUrl);
                    $recipe->set_ingredientCount($rIngredientCount);
                    $index++;
                }
                $ingredient= new Ingredient();
                $ingredient->set_name($iIngredientName);
                $ingredient->set_measurement($iMeasurement);
                $ingredient->set_qty($iQty);
                $ingredients->addItem($ingredient, $iIngredientName);
            }
        }
        $stmt->close();
        $link->close();
    } 
}

?>
<main>
<script>
    $(document).ready(function () {
        $('#errorMessage').toggle(false)
    $(document).on('click', '#ingredientTable .addRow', function () {

        var row = $(this).closest('tr');
        var clone = row.clone();
        var tr = clone.closest('tr');
        tr.find('input[type=text]').val('');
        tr.find('input[type=number]').val('');
        tr.find('select').val('qty');
        $(this).closest('tr').after(clone);
        var $span = $("#ingredientTable tr");
    });

    $(document).on('click', '#ingredientTable .removeRow', function () {
        if ($('#ingredientTable .addRow').length > 1) {
            $(this).closest('tr').remove();
        }

    });

});
function validate(){
    var form=$("#ingredientTable").closest('form')
    $(form.prop('elements')).each(function(){
        var missing = $(this).val()==="" || $(this).val()==='qty'
        $(this).parent().toggleClass('error',missing)
        $('#errorMessage').toggle(!missing)
    })
    return form.find(".error").length==0
}

</script>
<br /><br />
<section class="submitForm">
    <h3 id="submitTitle">Cookbook Recipe</h3><br />
    <form id="upload" method="post" enctype="multipart/form-data">
            <center>
            <label for="img">Select image:</label>
            <?php
                if($hasNewImg){
                    echo '<p>Current Image: '.$upload_file_name.'</p>';
                    echo  '<input type="file" id="img" name="img" accept="image/*" value="'.$upload_file_name.'">';
                } else if ($isEdit){
                    if($recipe->get_imageURL()==null || $recipe->get_imageURL() ==""){
                        $image = "emptyIcon.png";
                    } else {
                        $image = $recipe->get_imageURL();
                    }
                    echo '<p>Current Image: '.$image.'</p>';
                    echo  '<input type="file" id="img" name="img" accept="image/*" value="'.$recipe->get_imageURL().'">';
                } else {
                    echo '<p>Current Image: None</p>';
                    echo '<input type="file" id="img" name="img" accept="image/*">';
                }
            ?>
            <input type="submit" form="upload" value="Upload">
            </center>
    </form>
    <form id="update" action="processModifyRecipe.php" method="post">  
        <?php
            if($hasNewImg){
                echo "<img src='Images/".$upload_file_name."'style='max-width: 200px; max-height: 200px;'><br><br>";
                $image = $name;
            } elseif($isEdit){
                if($recipe->get_imageURL()==null || $recipe->get_imageURL() ==""){
                    $image = "emptyIcon.png";
                } else {
                    $image = $recipe->get_imageURL();
                }
                echo "<img src='Images/".$image."'style='max-width: 200px; max-height: 200px;'><br><br>";}?>
        <input type="hidden" name="recipeID" value="<?php if($isEdit){echo($recipe->get_id());}?>"> 
        <input type="hidden" name="isEdit" value="<?php echo $isEdit;?>"> 
        <?php 
            if($hasNewImg){
                $url = $upload_file_name;
            } else {
                if($recipe->get_imageURL()==null || $recipe->get_imageURL()==""){
                    $url = "emptyIcon.png";
                } else {
                    $url = $recipe->get_imageURL();
                }
            }
        ?>  
        <input type="hidden" name="imgURL" value="<?php echo $url;?>">
        <label for="recipeName">Name of Recipe:</label><br>
        <input type="text" id="recipeName" name="recipeName" value="<?php if($isEdit){echo($recipe->get_name());}?>" required><br><br> <!-- recipe_name -->

        <label for="cookTime">Cooking Time for Recipe:</label><br>
        <input type="text" id="cookTime" name="cookTime" value="<?php if($isEdit){echo($recipe->get_cookTime());}?>" required><br><br> <!-- cook_time -->

        <label for="ingredientTable">Ingredients for Recipe:</label><br><br>
        <table id="ingredientTable">
            <thead>
                <tr>
                    <th>Qty: </th>
                    <th>Measurement:</th>
                    <th>Ingredient Name:</th>
                </tr>
                </thead>
                <tbody id="tbody">
                    <?php 
                    if($isEdit){
                        $ingArray = $ingredients->allValues();
                        foreach ($ingArray as $i){
                            echo (
                            "<tr><td><input type='number' step='0.01' min=0 name='iQty[]' value=" . $i->get_qty() . "></td>
                            <td><select name='iMeasurement[]' id='qty'><option value='" . strtolower($i->get_measurement()) . "'>" . $i->get_measurement() . "</option><option value='qty'><option value='whole'>whole</option><option value='cup'>cup</option><option value='tbsp'>tbsp</option><option value='tsp'>tsp</option><option value='oz'>oz</option></select></td>
                            <td><input type='text' name='iName[]' value=". $i->get_name() ." ></td>
                            <td><input type='button' name='addRow' class='addRow' value='+' /></td>
                            <td><input type='button' name='removeRow' class='removeRow' value='-' /></td>");
                               
                        }
                        
                    }?>
                    <br>
                    <tr>
                        <td><input type='number' step='0.01' min=0 name='iQty[]'></td>
                        <td><select name='iMeasurement[]' id='qty'><option value='qty'><option value='whole'>whole</option><option value='cup'>cup</option><option value='tbsp'>tbsp</option><option value='tsp'>tsp</option><option value='oz'>oz</option></select></td>
                        <td><input type='text' name='iName[]'></td>
                        <td><input type='button' name="addRow" class="addRow" value='+' /></td>
                        <td><input type='button' name="removeRow" class="removeRow" value='-' /></td>
                    </tr>
                </tbody>
        </table><br>
        <div id="errorMessage">
            <h3 >Please fill out each row or remove it.</h3>
        </div>
        
        <!-- recipe_instructions -->
        <label for="instruction"><strong>Instructions for Recipe:</strong></label><br/><br/>
        <textarea id="instruction" name="instruction" rows="15" cols="50" required><?php if($isEdit){echo $recipe->get_instruction();}?></textarea><br/><br/>  
        <p><input form="update" type="submit" value="submit" name="submit" onclick="return validate()"></p><br/><br/>
    </form>
    
</section>
</main>
<?php include "footer.php"; ?>