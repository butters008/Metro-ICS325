<?php 

echo"
<!DOCTYPE html>
<html>
    <head>
        <title>ICS325 - Meal Planner</title>
        <meta charset='utf-8'/>
        <link rel='stylesheet' href='Style/style.css'>
        <link rel='stylesheet' href='Style/mealPlanner.css'>
        <link rel='stylesheet' href='Style/recipe.css'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css'>
        <style type=\"text/css\">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
        <script src=\"https://code.jquery.com/jquery-3.5.0.js\"></script>
        <script src=\"Script/site.js\"></script>
    </head>
    <body>
        <header>
            <img Style='width: 100%; height: 200px;'src='Images/kitchen.jpg' alt=''>
        </header>
        <nav>
            <ul>
                <li><a href='index.php'>Home</a></li>

                <li><a href='modifyRecipe.php'>Add Recipe</a></li>
                <li id='accountBtn' style='float: right;'><a href='profile.php'>My Profile</a></li>
            </ul>
        </nav>";

?>