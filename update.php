<!DOCTYPE html>
<html>
<head>
    <title>Add new match - Create notification for users</title>
    
  <title>Home</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="assets/vendor/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Graduate&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>

<?php include('functions.php') ?>

<form method="post" action="update.php" class="form-create">

    <?php global $db; 
    $usernameUp = "";
    $sql = "SELECT username FROM users "; // on selectione tout les users afin de pouvoir vérifier si il existe déja => ligne 76
	$sth = $db->prepare($sql); // on prépare la requete sql 
	$sth->execute(); // on execute la requete
	$result = $sth->fetchAll(PDO::FETCH_ASSOC); // on récupère tout les résultats et avec un fetchAll on les mets dans un tableau associatif
    $username = $result[1]['username'];
    ?>
    

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="usernameUp" value="<?php echo $usernameUp;?>">
		</div>
	
		<div class="input-group">
			<button type="submit" class="btn" name="update_btn">Update settings</button>
        </div>
        <?php echo display_error(); ?>
</form>

</body>
</html>