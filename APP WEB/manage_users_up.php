<div class="table-responsive-sm" style="max-height: 870px;"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
        <th>Card UID</th>
        <th>Name</th>
        <th>Gender</th>
        <th>CNE</th>
        <th>Email</th>
        <th>Branch</th>
      </tr>
    </thead>
    <tbody class="table-secondary">
    <?php
      //Connect to database
      require'conx.php';

        $sql = "SELECT * FROM etudiant ORDER BY id_etudiant DESC";
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
                  	
                  <TD><?php echo $row['card_token'];?></TD>
                  <TD><?php echo $row['Etu_name'];?></TD>
                  <TD><?php echo $row['gender'];?></TD>
                  <TD><?php echo $row['CNE'];?></TD>
                  <TD><?php echo $row['email'];?></TD>
                  <TD><?php echo $row['filiere_etu']?></TD>
                  </TR>
    <?php
            }   
        }
      }
    ?>
    </tbody>
  </table>
</div>