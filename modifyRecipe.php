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
                $key=$ingredient->get_name().$ingredient->get_measurement().$ingredient->get_qty();
                $ingredients->addItem($ingredient, $key);
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
        $('.img_upload').toggle(false)
        $('#update').toggle(false)
        const actualBtn = document.getElementById('img');
        const fileChosen = document.getElementById('file-chosen');
        actualBtn.addEventListener('change', function(){
            fileChosen.textContent = this.files[0].name
            $('#currentPicBtn').toggle(true)
        })
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

function newPic(){
    $('.img_upload').toggle(true)
    $('#update').toggle(false)
    $('#currentPicBtn').toggle(true)
}

function keepPic(){
    $('.img_upload').toggle(false)
    $('#update').toggle(true)
    $('#currentPicBtn').toggle(false)
}

</script>
<br /><br />
<section class="submitForm">
    <h3 id="submitTitle">Recipe Details</h3><br />
    <form id="upload" method="post" enctype="multipart/form-data">
            <center>
            <input type=button value="New Picture" onclick="newPic();"/>            
            <br/>
            <?php
                if($hasNewImg){
                    echo  '<input type="file" id="img" class="img_upload" name="img" accept="image/*" value="'.$upload_file_name.'" style="visibility:hidden">';
                    echo '<label class="img_upload" for="img">Chose Image</label>';
                    $current= $upload_file_name;
                } else if ($isEdit){
                    if($recipe->get_imageURL()==null || $recipe->get_imageURL() ==""){
                        $image = "emptyIcon.png";
                    } else {
                        $image = $recipe->get_imageURL();
                    }
                    echo  '<input type="file" class="img_upload" id="img" name="img" accept="image/*" value="'.$recipe->get_imageURL().'"  style="visibility:hidden">';
                    echo '<label class="img_upload" for="img">Chose Image</label>';
                    $current = $image;
                } else {
                    echo '<input type="file" class="img_upload" id="img" name="img" accept="image/*"  style="visibility:hidden">';
                    echo '<label class="img_upload" for="img">Chose Image</label>';
                    $current = "None";
                }
            ?>
            <span id="file-chosen" class="img_upload">No image chosen</span>
            <br/>
            <input class="img_upload" type="submit" form="upload" value="Upload">
            <br/>
            <br/>
            <label>Current Image: <?php echo $current?></label>
            <br/>
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
            <br/>
            <?php if($isEdit || $hasNewImg){
                echo('<input type=button id="currentPicBtn" value="Use Current Pic" onclick="keepPic();"/>');
                }?>
            </center>
    </form>
    <form id="update" action="processModifyRecipe.php" method="post">  
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
        <br/>
        <label for="recipeName">Name of Recipe:</label><br>
        <input type="text" id="recipeName" name="recipeName" value="<?php if($isEdit){echo($recipe->get_name());}?>" required><br><br> <!-- recipe_name -->

        <label for="cookTime">Cooking Time for Recipe:</label><br>
        <input type="text" id="cookTime" name="cookTime" value="<?php if($isEdit){echo($recipe->get_cookTime());}?>" required><br><br> <!-- cook_time -->

        <label for="ingredientTable">Ingredients for Recipe:</label><br>
        <table id="ingredientTable">
            <thead>
                <tr>
                    <th>How many? </th>
                    <th>Units:</th>
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
                            <td><select name='iMeasurement[]' id='qty'><option value='" . strtolower($i->get_measurement()) . "'>" . $i->get_measurement() . "</option><option value='qty'><option value='whole'>whole</option><option value='lb'>lb</option><option value='cup'>cup</option><option value='pt'>pt</option><option value='qt'>qt</option><option value='tbsp'>tbsp</option><option value='tsp'>tsp</option><option value='oz'>oz</option><option value='pinch'>pinch</option></select></td>
                            <td><input type='text' name='iName[]' value='". $i->get_name() ."' ></td>
                            <td><input type='button' name='addRow' class='addRow' value='+' /></td>
                            <td><input type='button' name='removeRow' class='removeRow' value='-' /></td>");
                               
                        }
                        
                    }?>
                    <br>
                    <tr>
                        <td><input type='number' step='0.01' min=0 name='iQty[]'></td>
                        <td><select name='iMeasurement[]' id='qty'><option value='qty'><option value='whole'>whole</option><option value='lb'>lb</option><option value='cup'>cup</option><option value='pt'>pt</option><option value='qt'>qt</option><option value='tbsp'>tbsp</option><option value='tsp'>tsp</option><option value='oz'>oz</option><option value='pinch'>pinch</option></select></td>
                        <td><input type='text' name='iName[]'></td>
                        <td><input type='button' name="addRow" class="addRow" value='+' /></td>
                        <td><input type='button' name="removeRow" class="removeRow" value='-' /></td>
                    </tr>
                </tbody>
        </table>
        <br>
        <div id="errorMessage">
            <h3 >Please fill out each row or remove it.</h3>
        </div>
        
        <!-- recipe_instructions -->
        <label for="instruction"><strong>Instructions for Recipe:</strong></label><br/><br/>
        <textarea id="instruction" name="instruction" rows="15" cols="50" required><?php if($isEdit){echo $recipe->get_instruction();}?></textarea><br/><br/>  
        <p><input form="update" type="submit" value="Update Recipe" name="submit" onclick="return validate()"></p><br/><br/>
    </form>
    
</section>
</main>
<?php include "footer.php"; ?>