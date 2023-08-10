<?php
//Connect to database
require 'conx.php';

//Add user
if (isset($_POST['user_add'])) {
    $Number = ' ';
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $Gender = $_POST['gender'];
    $dev_fil = $_POST['dev_fil'];
    $dev_card = $_POST['dev_card'];

    if (empty($Uname) || empty($Number) || empty($Email) || empty($Gender) || empty($dev_fil) || empty($dev_card)) {
        echo '<p class="alert alert-danger">Please, set etu infor!!</p>';
    } else {

        $resultat = mysqli_query($conn, "SELECT * FROM etudiant WHERE CNE='$Number'");
        if (mysqli_num_rows($resultat) > 0) {
            // La valeur existe déjà dans la base de données
            echo '<p class="alert alert-danger">this Token already existe!!</p>';
        } else {


            $sql = "INSERT INTO etudiant (Etu_name, CNE, gender, email,card_token, filiere_etu) VALUES(?,?,?,?,?,?)";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo '<p class="alert alert-danger">SQL Error</p>';
            } else {
                mysqli_stmt_bind_param($result, "ssssss", $Uname, $Number, $Gender, $Email, $dev_card,$dev_fil);
                mysqli_stmt_execute($result);
                echo 1;
                $sql = "UPDATE card SET card_status=1 WHERE card_token=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_Select_login1";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($result, "s", $dev_card);
                        mysqli_stmt_execute($result);
                        exit();
                    }
                }
            }
            mysqli_stmt_close($result);
            mysqli_close($conn);
           
        }
    
}else{
    header("location: index.php");
    exit();
}

?>