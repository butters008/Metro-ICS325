
// INDEX FUNCTIONS
var instructions = new Array();

function nextSpot() {
    if( typeof nextSpot.counter == 'undefined' || nextSpot.counter > 6 ) {
        nextSpot.counter = 1;
    } else {
        nextSpot.counter++;
    }
    return nextSpot.counter.toString();
}
function updateRecipe(id){
    var current = document.getElementById('current');
    if(current.value == null || current.value == ""){
        document.getElementById('add_btn').hidden = false;
        document.getElementById('edit_link').hidden = false;
    }
    current.value = id;
    document.getElementById('recipeInfo').innerHTML = instructions[recipeid = id];
}

function addToList(){
    var number = nextSpot();
    var id = ["one","two","three","four","five","six","seven"];
    var img = "img" + number;
    currentID = document.getElementById('current').value; 
    document.getElementById(id[(number-1)]).value =  currentID
    spot = document.getElementById(img);
    spot.src = document.getElementById(currentID.toString()).src;
    spot.hidden = false;
}

function setSort(){
    $sort = document.getElementById('sort').value
    document.cookie = "sort="+$sort;
    if($sort == 'r.recipe_id'){
        document.cookie = "direction=DESC";
    } else {
        document.cookie = "direction=ASC";
    }

    $('#gallery').load('index.php #gallery');
}
function storeInstruction(key, value){
    instructions.push(key.toString(), value);
}
