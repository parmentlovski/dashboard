<title>Add pictures</title>
</head>
<body>

<?php include('../functions.php');
 include('../header.php');
include('../nav.php') ?>

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
	
<?php include('../footer.php') ?>	

