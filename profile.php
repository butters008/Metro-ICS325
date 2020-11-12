<?php include "header.php"; ?>
<?php
// Initialize the session
session_start();


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "dbCred.php";

// Define and initialize variables
$email = htmlspecialchars($_SESSION["email"]);
$dates = "";

 // Prepare a select statement
 $sql = "SELECT shopping_list_date FROM shopping_list WHERE user_email = ? ORDER BY shopping_list_date DESC";

 if($stmt = mysqli_prepare($link, $sql)){
     // Bind variables to the prepared statement as parameters
     mysqli_stmt_bind_param($stmt, "s", $param_email);

     // Set parameters
     $param_email = $email;
     
     // Attempt to execute the prepared statement
         if(mysqli_stmt_execute($stmt)){
             // Store result
             $list_count = mysqli_stmt_store_result($stmt); 
             // If there are any results then store them in list
             if(mysqli_stmt_num_rows($stmt) > 0){
                 // Bind result variables
                mysqli_stmt_bind_result($stmt, $dates);
                if (mysqli_stmt_fetch($stmt)){
                   var_dump($dates);
                   // TODO figure out how this returns multiple values and how to display them below in a link
                }
             }

         }
    }
         
?>
<main>
    <div id="profile">
        <?php
        $email = htmlspecialchars($_SESSION["email"]);
        echo("<p>Email: ".$email."</p>");
        echo('<a href="resetpassword.php">Reset Password</a>'); 
        echo('<p>Past Shopping Lists:</p>');
        //TODO Will need a function to find and display by date the past shopping list and should link to list.php
        // echo('<ul id="pastList">');
        // foreach ($lists as $date){
        //     echo("<li><a href=\"list.php\">$date</a></li>");
        //     // I think this link can be done using query parameters example list.php?email=user@email.com&date=11012020 but need to do more digging. 
        //     // If not for sure in a cookie or session value, I am just real bad at that still
        // }
        // echo('</ul>');
         echo('<a href="logout.php">Log Out</a>');
        // // We could add an option here to delete an account if we need to make that kind of call. Similar to the logout.php file
        // ?>
    </div>
</main>

<?php include "footer.php"; ?>