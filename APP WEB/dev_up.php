<?php
session_start();
?>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Card Token</th>
				<th>Card Date</th>
				<th>Card Status</th>

			</tr>
		</thead>
		<tbody>
			<?php
			require 'conx.php';
			$sql = "SELECT * FROM card ORDER BY card_token ASC";
			$result = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($result, $sql)) {
				echo '<p class="error">SQL Error</p>';
			} else {
				mysqli_stmt_execute($result);
				$resultl = mysqli_stmt_get_result($result);
				echo '<form action="" method="POST" enctype="multipart/form-data">';
				while ($row = mysqli_fetch_assoc($resultl)) {
					if ($row["card_status"] == 0) {
						$d = "true";
					} else {
						$d = "false";
					}

					echo '<tr>
							        <td>' . $row["card_token"] . '</td>
							        <td>' . $row["card_date"] . '</td>
							        <td>' . $d . '</td>
									<td>
								    	<button type="button" class="dev_del btn btn-danger" id="del_' . $row["card_token"] . '" data-id="' . $row["card_token"] . '" title="Delete this device"><span class="glyphicon glyphicon-trash"></span></button>
								    </td>
							      </tr>';
				}
				echo '</form>';
			}
			?>
		</tbody>
	</table>
</div>