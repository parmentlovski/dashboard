<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Add new match - Create notification for users</title>
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
		<h2>Admin - create notification</h2>
	</div>
	
	<form method="post" action="create_notif.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Date du match :</label>
			<input type="date" name="date_event" >
		</div>
        <div class="input-group">
			<label>Lieu du match :</label>
			<input type="text" name="lieu_event" >
		</div>
        <div class="input-group">
			<label>Nombre de places necessaire :</label>
			<input type="number" name="dispo_event" >
		</div>


        <div class="input-group">
			<button type="submit" class="btn" name="notif_btn"> + Create season</button>
		</div>
	</form>
</body>
</html>