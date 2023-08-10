<?php
//Connect to database
require 'conx.php';
date_default_timezone_set('Asia/Damascus');
$d = date("Y-m-d");
$t = date("H:i:sa");

if (isset($_GET['card_token']) ) {

    $card_uid = $_GET['card_token'];

    
    $sql = "SELECT etudiant.id_etudiant,Etu_name,card.card_token FROM etudiant,card WHERE card.card_token=? and etudiant.card_token = card.card_token";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_card";
        exit();
    } else {
        mysqli_stmt_bind_param($result, "s", $card_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {
            //An existed Card has been detected for Login or Logout
            
                $sql = "INSERT INTO attendance (id_etudiant) VALUES (?)";
                $Uname = $row['Etu_name'];
                $id = $row['id_etudiant'];
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_login1";
                    exit();
                } else {
                    
                    mysqli_stmt_bind_param($result, "s", $id);
                   
                    mysqli_stmt_execute($result);
                    echo "Access Allowed ";
                }

        } else {
            echo "Not Allowed!";
            exit();
        }
    }
}