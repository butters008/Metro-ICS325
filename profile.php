<?php include "header.php"; ?>
<?php
// Initialize the session
session_start();

// Setting this just for development and testing. Remove once we have connection
$_SESSION["loggedin"] = true;

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//TODO These will eventually come from the database
$email = "user@email.com"; 
$lists = ["11/01/2020", "10/25/2020"];

?>
<main>
    <!-- TODO Replace with user variables from database-->
    <div id="profile">
        <?php
        echo("<p>Email: $email</p>");
        echo('<a href="resetpassword.php">Reset Password</a>'); 
        echo('<p>Past Shopping Lists:</p>');
        //TODO Will need a function to find and display by date the past shopping list and should link to list.php
        echo('<ul id="pastList">');
        foreach ($lists as $date){
            echo("<li><a href=\"list.php\">$date</a></li>");
            // I think this link can be done using query parameters example list.php?email=user@email.com&date=11012020 but need to do more digging. 
            // If not for sure in a cookie or session value, I am just real bad at that still
        }
        echo('</ul>');
        echo('<a href="logout.php">Log Out</a>');
        // We could add an option here to delete an account if we need to make that kind of call. Similar to the logout.php file
        ?>
    </div>
</main>

<?php include "footer.php"; ?>