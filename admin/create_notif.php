<?php include('../functions.php') ;
 include('../header.php'); 
  include('../nav.php') ?>

<title>Add notification</title>
</head>
<body>

	<div class="header">
		<h2>Create notification</h2>
	</div>
	
	<form method="post" action="create_notif.php" class="form-create">

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

<?php include('../footer.php') ?>	
