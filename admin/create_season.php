<title>Create season</title>
</head>
<body>

<?php include('../functions.php');
 include('../header.php');
//  include('../nav.php') ?>

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

	
<?php
      global $db;
      $recupMail = "";
      $theRecupMail = $db->prepare("SELECT `email`, `username` FROM `users`");
      if ($theRecupMail->execute(array())) {
        $recupMail  = $theRecupMail->fetchAll(PDO::FETCH_ASSOC);
      }
      
      ?>

      <form class="envoi_mail" method="post" action="create_season.php">
        <textarea name="textarea" id="" cols="40" rows="40"></textarea>
        <?php
        foreach ($recupMail as $row) {
          echo '<input type="checkbox" name="users[]" value="' . $row['email'] . '" /> ' . $row['username'];
        }
        ?>
        <button name="submitt" >envoyer</button><style> button {
			background-color: blue;
		}</style>
      
        <span class="span"></span>
      </form>

    </section>
    <?php
    if (isset($_REQUEST['users'])) {
      $users = $_REQUEST['users'];
    }


    if (isset($_POST['submitt'])) {
      send_mail();
    }


function send_mail(){
  global $users;
      if (!empty($users)) {
        foreach ($users as $email) {
          $to      =  $email;
          $subject = 'Nouveau Match';
          $message = $_POST['textarea'];
          $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: entraineur' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
          mail($to, $subject, $message, $headers);
        }
      }
    }

    ?>

<?php include('../footer.php') ?>	
