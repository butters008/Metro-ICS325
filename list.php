<?php include "header.php";
require_once "mockData.php";
require_once "ingredientCollection.php"; 
?>
<?php
// TODO If user is logged in create a shopping list class and add it to the associated user
$date = date("m-d-Y");
$ids = array();
$ingredients = array();
array_pop($ids);
array_pop($ingredients);
$ids = getIDs();
$ingredients = getIngredients($mockRecipeList, $ids);
$masterList = getIngredientCollection($ingredients);

function getIDs(){
    $labels = array('one','two','three','four','five','six','seven');
    $output = array();
    array_pop($output);
    foreach($labels as $label){
        if(isset($_POST[$label])){
            array_push($output, $_POST[$label]);
        }
    }
    return $output;
}

// TODO This will have to come from the database but for now we have to cycle through mock data up to 7 times which is terrible
function getIngredients($list, $idList){
    $output = array();
    array_pop($output);
    foreach($idList as $id){
        foreach($list as $item){
            $num = intval($id);
            if($item->id == $num){
                array_push($output,($item->get_ingredientList()));
            }
        }
    }   
    return $output;
}

// TODO find a way to combine ingredients to avoid duplicates
function getIngredientCollection($list){
    $collection = new IngredientCollection();
    foreach($list as $arr){
        foreach($arr as $ing){
            $collection->addItem($ing);
        }
    }
    return $collection;
}

?>

<main>
    <h2>Shopping List:</h2>
    <p>Generated <?php echo($date)?></p>
    <ul>
    <?php
    // TODO do actual calculation rather than fake it.
        foreach($masterList->all() as $ingredient){
            if(!isset($count)){$count=1;} else {$count++;}
            if($count > 10){break;}
            $qty = $ingredient->qty *7;
            echo("<li>".$qty." ".$ingredient->measurement." ".$ingredient->name."</li>");
        }
    ?>
    </ul>
    
</main>

<?php include "footer.php"; ?>