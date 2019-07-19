
<title>Update</title>
</head>
<body>
<?php include('functions.php');
 include('header.php'); ?>


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
			<input type="text" name="usernameUp" id="usernameUp" value="<?php echo $result_value[0]['username'] ;?>" disabled>
			<p id="modif-username" class="badge badge-danger">Modifier</p>
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="emailUp" id="emailUp" value="<?php echo $result_value[0]['email'] ;?>" disabled>
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
		<?php echo display_validation(); ?>
		
        <?php echo display_error(); ?>
</form>
<a href="/index.php">Retour en arrière</a>

<?php include('footer.php'); ?>

