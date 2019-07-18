<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL - Create season</title>
	<head>
  <title>Home</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="assets/vendor/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Graduate&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">


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

<?php  //include('../nav.php') ?>
	<div class="header">
		<h2>Create user</h2>
    </div>
    
    <section id='add-pp'>
	
	<form method="post" action="create_pp.php" class="form-create">

		<?php echo display_error(); ?>
		
		<div class="input-group">
			<label>Add pictures</label>
			<input type="file" name="add-pp" accept="image/png, image/jpeg">
        </div>

        <div class="input-group">
			<button type="submit" class="btn" name="add_pp_btn"> + Add pictures</button>
		</div>
    </form>
    
    </section>
</body>
</html>