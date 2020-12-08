
// INDEX FUNCTIONS
var instructions = {};

// Stores all the instructions in an array for display in the How to Make box
function storeInstruction(key, value){
    instructions[key.toString()] = value;
}

// Updates the How to Make box with clicked recipe info
function updateRecipe(id){
    var current = document.getElementById('current');
    if(current.value == null || current.value == ""){ 
        document.getElementById('add_btn').hidden = false;
        document.getElementById('edit_link').hidden = false;
    }
    current.value = id;
    document.getElementById('recipeInfo').innerHTML = instructions[id.toString()];
    document.getElementById('edit_link').href = "modifyRecipe.php?recipe_id="+id;
}

// Figures out which meal to add the recipe to when Add to List is pressed
function nextSpot() {
    if( typeof nextSpot.counter == 'undefined' || nextSpot.counter > 6 ) {
        nextSpot.counter = 1;
    } else {
        nextSpot.counter++;
    }
    return nextSpot.counter.toString();
}

// Adds the recipe to the meal box based on the next spot
function addToList(){
    var number = nextSpot();
    var id = ["one","two","three","four","five","six","seven"];
    var img = "img" + number;
    currentID = document.getElementById('current').value; 
    document.getElementById(id[(number-1)]).value =  currentID
    spot = document.getElementById(img);
    spot.src = document.getElementById(currentID.toString()).src;
    spot.hidden = false;
    document.cookie = id[(number-1)]+"="+currentID;
    $('#recs').load('index.php #recs');
}


// Sets cookies and reloads the gallery with updated database calls for a sorted list
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
// Search the recipe list
function search(term){
    var searchBox = document.getElementById('search');
    if(searchBox.value.length > 0){
        document.cookie ="search="+term;
    } else {
        eraseCookie('search');
    }

    $('#gallery').load('index.php #gallery');
}

function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
    $('')
}

function printList(){
    var divContents = document.getElementById("list").innerHTML; 
    var a = window.open('', '', 'height=500, width=500'); 
    a.document.write('<html>'); 
    a.document.write('<body >'); 
    a.document.write(divContents); 
    a.document.write('</body></html>'); 
    a.document.close(); 
    a.print(); 
}
