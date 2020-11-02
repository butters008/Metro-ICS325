
<?php 
//including this for now, but will modify and continue working when we upload to server
?>

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

        //Methods

        function displayCookTime(){
            if ($this->cookTime < 60) {
                return "$this->cookTime minutes";
            } else {
                $hours = $this->cookTime/60;
                $minutes = $this->cookTime%60;
                return "$hours hours $minutes minutes";
            }
        }

        function displayIngredients(){
            if(isset($ingredientList)){
                foreach($ingredientList as $ingredient){
                    echo("\t$ingredient->qty $ingredientList->measurement $ingredient->name");
                }
            }
        }

        public function displayRecipe(){
            echo("Recipe: ".$this->name);
            echo("Cook Time: ".$this->displayCookTime());
            echo("Ingredients:");
            $this->displayIngredients();    
        }
    }
?>
