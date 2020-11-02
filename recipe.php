<?php
class Recipe {
        //Properties
        public $id;
        public $name;
        public $instruction;
        public $ingredientList;
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
        function set_ingredientName($ingredientName) {
            $this->ingredientName = $ingredientName;
        }
        function get_ingredientName(){
            return $this->name;  
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
