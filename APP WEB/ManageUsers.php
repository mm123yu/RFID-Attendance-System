<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Manage Users</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/manageusers.css">

	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.js"
		integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
		</script>
	<script type="text/javascript" src="js/bootbox.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="js/manage_users.js"></script>
	<script>
		$(window).on("load resize ", function () {
			var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
			$('.tbl-header').css({ 'padding-right': scrollWidth });
		}).resize();
	</script>
	<script>
		$(document).ready(function () {
			$.ajax({
				url: "manage_users_up.php",
				type: 'POST',
		      	data: {
		        'manage_users_up': 1,
		  		}
			}).done(function (data) {
				$('#manage_users').html(data);
			});
			setInterval(function () {
				$.ajax({
					url: "manage_users_up.php",
					type: 'POST',
		      	data: {
		        'manage_users_up': 1,
		  		}
				}).done(function (data) {
					$('#manage_users').html(data);
				});
			}, 5000);
		});
	</script>
</head>

<body>
	<?php include 'header.php'; ?>
	<main>
		<h1 class="slideInDown animated">Ajouter Un Nouveu Etudiant(e)</h1>
		<div class="form-style-5 slideInDown animated">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="alert_user"></div>

				<legend> Student Info</legend>
				<input type="hidden" name="user_id" id="user_id">
				<input type="text" name="name" id="name" placeholder="Student Name...">
				<input type="text" name="number" id="number" placeholder="CNE...">
				<input type="email" name="email" id="email" placeholder="Student Email ...">


				<?php
				isset($_POST["dev_fil"]) == "..." ?>

				<label for="dev_fil"><b>Student Branch:</b></label>
				<select class="dev_fil" name="dev_fil" id="dev_fil" style="color: #000;">
					<option value="MBD">MBD</option>
					<option value="SIM">SIM</option>
				</select>

				<label for="dev_card"><b>Student Card:</b></label>
				<select name="dev_card" id="dev_card" class="dev_card" style="color: #000">
					<option disabled selected>-- Select Device --</option>
					<?php
					include "conx.php"; // Using database connection file here
					$records = mysqli_query($conn, "SELECT card_token From card WHERE card_status= 0"); // Use select query here 
					while ($row = mysqli_fetch_array($records)) {
						echo "<option value='" . $row['card_token'] . "'>" . $row['card_token'] . "</option>"; // displaying data in option menu
					}
					?>
				</select>

			


				<label for="gender">Gender</label>
				<input type="radio" name="gender" class="gender" value="Female">Female
				<input type="radio" name="gender" class="gender" value="Male" checked="checked">Male


				<button type="submit" name="user_add" class="user_add">Add User</button>
			</form>
		</div>

		<!--User table-->
		<div class="section">

			<div class="slideInRight animated">
				<div id="manage_users"></div>
			</div>
		</div>
	</main>
</body>

</html>