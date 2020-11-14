<?php
require_once "ingredient.php";

class Recipe {
        //Properties
        public $id;
        public $name;
        public $instruction;
        public $ingredientList = array();
        public $cookTime;
        public $imageURL;

        //Getter/Setter
        function set_id($id){
            $this->id = $id;
        }
        function get_id(){
            return $this->id;
        }
        function set_name($name){
            $this->name = $name;
        }
        function get_name(){
            return $this->name;
        }
        function set_ingredientList($ingredientList) {
            $this->ingredientList = $ingredientList;
        }
        function get_ingredientList(){
            return $this->ingredientList;  
        }
        function set_cookTime($cookTime) {
            $this->cookTime = $cookTime;
        }
        function get_cookTime(){
            return $this->cookTime;
        }
        function set_instruction($instruction){
            $this->instruction = $instruction;
        }
        function get_instruction(){
            return $this->instruction;
        }
        function set_imageURL($imageURL){
            $this->imageURL = $imageURL;
        }
        function get_imageURL(){
            return $this->imageURL;
        }

        //Methods

        function displayCookTime(){
            if ($this->cookTime < 60) {
                return "$this->cookTime minutes";
            } else {
                $hours = intdiv($this->cookTime,60);
                $minutes = $this->cookTime%60;
                return "$hours hours $minutes minutes";
            }
        }

        public function displayIngredients(){
            $output = "<ui>";
            foreach($this->ingredientList as $ing){
                $output = $output."<li>".$ing->get_qty()." ".$ing->get_measurement()." ".$ing->get_name()."</li>";
            }
            $output = $output."</ul>";
            return $output;
        }

        public function displayRecipe(){
            $output = "<h3>Recipe: ".$this->name."</h3>"."<p>Cook Time: ".$this->displayCookTime()."</p>"."<p>Instructions: ".trim($this->instruction, "\n")."</p>"."<p>Ingredients: </p>".$this->displayIngredients();   
            return $output; 
        }

        public function addIngredient($ingredient){
            array_push($this->ingredientList, $ingredient);   
        }

    }
?>
