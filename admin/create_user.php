<title>Create user</title>
</head>
<body>
<?php include('../functions.php');
 include('../header.php'); 
include('../nav.php') ?>

	<div class="header">
		<h2>Create user</h2>
	</div>

	<form method="post" action="create_user.php" class="form-create">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>Season</label>
			<select name="season_user" id="season_user">
				<option value=""></option>
				<?php

				$sql = "SELECT * FROM saison";
				$sth = $db->prepare($sql);
				$sth->execute();
				$result = $sth->fetchAll(PDO::FETCH_ASSOC);

				if (count($result) > 0) {
					// output data of each row
					foreach ($result as $saison) {
						?><option><?php echo $saison["date_saison"] ?></option>
					<?php
					}
				}
				?>
			</select>

		</div>
		<div class="input-group">
			<label>User type</label>
			<select name="user_type" id="user_type">
				<option value=""></option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn"> + Create user</button>
		</div>
	</form>

<?php include('../footer.php') ?>	
