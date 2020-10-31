<?php 
    
    //testing connection to server
    $severname = "ics325fa2005@sp-cfsics.metrostate.edu";
    $database = "ics325fa2005";
    $username = "ics325fa2005";
    $password = "2944";

    $conn = mysqli_connect($severname, $username, $password, $database);

    if ($conn->connect_error){
        die("Connection Failed: ".$connect_error);
    }

    $sql = "SELECT * FROM recipe";
    $result = $conn->query($sql);

?>