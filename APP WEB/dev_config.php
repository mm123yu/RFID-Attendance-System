<?php 
session_start();
require('conx.php');

if (isset($_POST['dev_add'])) {

    $dev_name = $_POST['dev_name'];

    if (empty($dev_name)) {
        echo '<p class="alert alert-danger">Please, set device Token!!</p>';
    }
        else{  $resultat = mysqli_query($conn, "SELECT * FROM card  WHERE card_token='$dev_name'");
       if (mysqli_num_rows($resultat) > 0) {
        // La carte existe déjà dans la base de données
        echo '<p class="alert alert-danger">this Token already existe!!</p>';
    } else {
        $sql = "INSERT INTO card (card_token) VALUES(?)";
        $result = mysqli_stmt_init($conn);
        if ( !mysqli_stmt_prepare($result, $sql)){
            echo '<p class="alert alert-danger">SQL Error</p>';
        }
        else{
            mysqli_stmt_bind_param($result, "s", $dev_name);
            mysqli_stmt_execute($result);
            echo 1;
        }
    mysqli_stmt_close($result); 
    mysqli_close($conn);
    }}
     
}
elseif (isset($_POST['dev_del'])) {

    $dev_del = $_POST['dev_del'];

    $sql = "DELETE FROM card  WHERE card_token=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo '<p class="alert alert-danger">SQL Error</p>';
    }
    else{
        mysqli_stmt_bind_param($stmt, "i", $dev_del);
        mysqli_stmt_execute($stmt);
        echo 1;
        mysqli_stmt_close($stmt); 
        mysqli_close($conn);
    }
}
else{
    header("location: index.php");
    exit();
}
//*********************************************************************************
?>