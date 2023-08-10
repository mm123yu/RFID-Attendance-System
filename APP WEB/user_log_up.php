<?php  
session_start();
?>
<div class="table-responsive" style="max-height: 500px;"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
       
        <th>Name</th>
        <th>CNE</th>
        <th>Branch</th>
        <th>Card Token</th>
        <th>Date-Time</th>
      
      </tr>
    </thead>
    <tbody class="table-secondary">
      <?php

        //Connect to database
        require'conx.php';
      

         $sql = "SELECT Etu_name,CNE,filiere_etu,card_token,checkindate FROM attendance,etudiant where etudiant.id_etudiant = attendance.id_etudiant ";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }
        else{
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if (mysqli_num_rows($resultl) > 0){
                while ($row = mysqli_fetch_assoc($resultl)){
        ?>
                  <TR>
                  <TD><?php echo $row['Etu_name'];?></TD>
                  <TD><?php echo $row['CNE'];?></TD>
                
                  <TD><?php echo $row['filiere_etu'];?></TD>
                  <TD><?php echo $row['card_token'];?></TD>
                  <TD><?php echo $row['checkindate'];?></TD>
              
                  </TR>
      <?php
                }
            }
        }
        // echo $sql;
      ?>
    </tbody>
  </table>
</div>