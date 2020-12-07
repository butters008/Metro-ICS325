<?php include "header.php";
    require_once "dbCred.php";
 ?>
<?php
// Initialize the session
session_start();


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


// Define and initialize variables
$email = $_SESSION["email"];
$dates = array();

 // Prepare a select statement
 $sql = "SELECT s.shopping_list_date, s.shopping_list_id FROM shopping_list as s WHERE user_email = ? ORDER BY shopping_list_date DESC";

if($stmt = mysqli_prepare($link, $sql)){
     // Bind variables to the prepared statement as parameters
     mysqli_stmt_bind_param($stmt, "s", $param_email);
     // Set parameters
     $param_email = $email;
     // Attempt to execute the prepared statement
         if(mysqli_stmt_execute($stmt)){
            // Bind results
            mysqli_stmt_bind_result($stmt, $date, $list_id);
                while (mysqli_stmt_fetch($stmt)){
                   $dates[$list_id] = $date;
                }
        }
};    
         
?>
<main>
    <div id="profile">
        <?php
        $email = $_SESSION["email"];
        echo("<h1>Email: ".$email."</h1>");
        echo('<a href="resetpassword.php"><input type=button value = "Reset Password" /></a>'); 
        echo('<h2>Past Shopping Lists:</h2>');
        echo('<ul id="pastList">');
        foreach ($dates as $id=>$date){
            $prettyDate = new DateTime($date);
            echo("<li><a href=\"pastList.php?sli=".$id."\">".$prettyDate->format("D, M jS Y - g:i a")."</a></li>");
        }
        echo('</ul>');
         echo('<a href="logout.php"><input type=button value="Log Out" /></a>');
        ?>
    </div>
</main>

<?php include "footer.php"; ?>