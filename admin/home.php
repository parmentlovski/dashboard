<?php
include('../functions.php');
include('../header.php'); 
include('../nav.php'); ?>
<title>Welcome to Besançon New Cowté</title>
</head>
<body>
<?php
if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
 
  ?>
<main class="background-dashboard">
	<section>
	</section>
</main>
<?php include('../footer.php') ?>	