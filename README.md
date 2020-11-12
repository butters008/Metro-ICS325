# MealPlanner
Final Project for ICS325 and we are using HTML, CSS, JavaScript, PHP, and MySQL

WireFrame Mock-Ups
https://wireframe.cc/pro/pp/e2966e324385170

DataBase Design in draw.io format
https://mnscu-my.sharepoint.com/:u:/r/personal/ra7510qo_go_minnstate_edu/Documents/ICS325.drawio?csf=1&web=1&e=3udwaB


TODO:
    New File:
        ~~1. Write the SQL statements to create the tables/keys based on the existing database schema~~
    index.php
        2. Figure out what SQL statements are needed to make calls to load the recipe data and filter/sort
        3. Remove mock data
        4. Refactor based on using database calls instead of mock data
        5. Verify images work on server
    ingredient.php
        6. Write functions to convert measurements so shopping list can combine ingredients
    ingredientCollection.php
        
    list.php
        7. Figure out SQL statements needed to create a new shopping list.  User has a list has many recipes has many ingredients -> probably only need to figure out adding recipes to the list though 
        8. Remove all mock data and refactor for db data
        9. Figure out how to display the ingredients after the DB call
        10. Find a way to combine ingredients to avoid duplicates
    login.php
        ~~11. Hook up database.~~
        ~~12. Convert variable names in SQL to match our tables~~
    logout.php

    mockData.php
        13. Delete
    modifyRecipe.php
        14. Add database connections to use recipe (or recipeCollection?) db calls
        15. Add form validation to accout for SQL injection and make sure we get valid data (numbers where we should, etc)
        16. If existing recipe, prefill fields
        17. Add recipe pictures and data
    profile.php
        18. Hook up database.
        19. Show shopping list data
    recipe.php
        20. Figure out SQL statements for CREATE and UPDATE - Do we want a recipeCollection file like the ingredient collection
    resetpassword.php
        ~~21. Hook up database.~~
        ~~22. Convert variable names in SQL to match our tables~~
    shoppingList.php
        23. Add db connection and SQL statements
        24. Display shopping list dates in a link from DB query results
    signup.php
        ~~25. Hook up database.~~
        ~~26. Convert variable names in SQL to match our tables~~
    user.php
        27. Verify that all the dB calls are handled in the login/signup/resetpassword/profile pages
    

