<!DOCTYPE html>
<html>
<head>
    
  <title>Settings</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="assets/vendor/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Graduate&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>

<?php include('functions.php') ?>

<?php 
$idUser = $_SESSION['user']['id'];


$sql_value = "SELECT * FROM users WHERE id ='$idUser'";
$sth_value = $db->prepare($sql_value);
$sth_value->execute();
$result_value = $sth_value->fetchAll(PDO::FETCH_ASSOC);

$resultUsername = $result_value[0]['username'];
$resultEmail = $result_value[0]['email'];


?>

<form method="post" action="update.php" class="form-create">
    

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="usernameUp" id="usernameUp" value="<?php echo $resultUsername ;?>" disabled>
			<p id="modif-username" class="badge badge-danger">Modifier</p>
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="emailUp" id="emailUp" value="<?php echo $resultEmail ;?>" disabled>
			<p id="modif-email" class="badge badge-danger">Modifier</p>
		</div>
		<p id="change">Change password </p>
		<div class="container-new-mdp">
		<div class="input-group">
			<label>New password</label>
			<input id="passwordUp" type="password" name="passwordUp">
		</div>
		<div class="input-group">
			<label>Confirm new password</label>
			<input id="passwordUp2" type="password" name="passwordUp2">
		</div>
		</div>
		<div class="input-group">
			<label>Confirmez votre ancien mot de passe</label>
			<input id="confirmPassword" type="password" name="passwordVerif">
		</div>
		
		<div class="input-group">
			<button type="submit" id="form-update" class="btn" name="update_btn" disabled>Update settings</button>
        </div>
        <?php echo display_error(); ?>
</form>
<a href="/index.php">Retour en arrière</a>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
  <script type="text/javascript" src="assets/vendor/js/mdb.min.js"></script>
<script src="assets/js/update.js"></script>
</body>
</html>