
<?php include('functions.php');
 include('header.php');
include('nav.php') ;

if (!isAdmin()):
    if ("GET" === $_SERVER["REQUEST_METHOD"]) {
      // Renvoie l'utilisateur à la racine du serveur
      header("Location: /");
      // Met fin au script par mesure de sécurité
      die();
    }
    endif ;
?>

<title>Create season</title>
</head>
<body>

<div class="header">
		<h2>Create user</h2>
	</div>
	
	<form method="post" action="create_season.php" class="form-create">

		<?php echo display_error(); ?>
		


		<div class="input-group">
			<label>Date saison :</label>
			<input type="text" name="season" >
		</div>

        <div class="input-group">
			<button type="submit" class="btn" name="season_btn"> + Create season</button>
		</div>
	</form>


<?php include('footer.php') ?>	
