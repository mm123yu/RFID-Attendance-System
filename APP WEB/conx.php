<?php
/* Database connection settings */
	$servername = "localhost";
    $username = "root";		// phpmyadmin username.
    $password = "";			//password put it here
    $dbname = "ouf";
    

    $conn = mysqli_connect($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
?>