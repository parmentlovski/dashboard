<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL - Create season</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<style>
		.header {
			background: #003366;
		}
		button[name=register_btn] {
			background: #003366;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Admin - create user</h2>
	</div>
	
	<form method="post" action="create_season.php">

		<?php echo display_error(); ?>
		


		<div class="input-group">
			<label>Date saison :</label>
			<input type="text" name="season" >
		</div>

        <div class="input-group">
			<button type="submit" class="btn" name="season_btn"> + Create season</button>
		</div>
	</form>
</body>
</html>