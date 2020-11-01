<?php include "header.php"; ?>

<main>
<br />
    
    <br /><br />
    <section class="submitForm">
        <h3 id="submitTitle">Submit a recipe for Cookbook</h3>
        <form action="" method="post">  
            <!--(Thought process for menu decission was from Applebees) 
                Make them choose: dinner -  dessert/snack -  appatizer -->
            
            <!-- Then comes basic information for recipe
                name, description, assigned 1 of three icons that user previous choosen -->
                <label for="recipeName">Name of Recipe:</label><br>
                <input type="text" id="recipeName" name="recipeName"><br>
                <label for="recipeDescription">Description of Recipe:</label><br>
                <input type="text" id="recipeDescription" name="recipeDescription">

            <!-- Adding ingredents to recipe, making this an array or table 
            Example taken from: https://www.youtube.com/watch?v=qYbkQpSI9_o -->

            <!-- This is where we tell them to make the instructions as to how to make the recipe
            Thinking that this will output to a text file, than we store this locally on the page 
            For now localhost/server, but once we get further developed, we store on website server
            
            REASON: We take the textfile and load onto instruction on main page with correct formatting (I believe) -->


        </form>
    </section>


</main>

<?php include "footer.php"; ?>