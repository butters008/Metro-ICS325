<?php 
    

    // //testing connection to server
    // $severname = "ics325fa2005@sp-cfsics.metrostate.edu";
    // $database = "ics325fa2005";
    // $username = "ics325fa2005";
    // $password = "2944";

    // $conn = mysqli_connect($severname, $username, $password, $database);

    // if ($conn->connect_error){
    //     die("Connection Failed: ".$connect_error);
    // }

    // $sql = "SELECT * FROM recipe";
    // $result = $conn->query($sql);

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'ics325fa2005@sp-cfsics.metrostate.edu');
define('DB_USERNAME', 'ics325fa2005');
define('DB_PASSWORD', '2944');
define('DB_NAME', 'ics325fa2005');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
