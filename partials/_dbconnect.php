<?php
    // Script to connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sforum";

    $conn = mysqli_connect($servername, $username, $password, $database);

    // if we put the password in above variable then it throws error
    // if we want to show unsuccessful connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
    
?>