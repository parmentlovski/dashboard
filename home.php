<?php
include('functions.php');
include('header.php'); 
include('nav.php'); 

if (!isAdmin()):
    if ("GET" === $_SERVER["REQUEST_METHOD"]) {
      // Renvoie l'utilisateur à la racine du serveur
      header("Location: /");
      // Met fin au script par mesure de sécurité
      die();
    }
	endif ;?>
	
<title>Welcome to Besançon New Cowté</title>
</head>
<body>
<?php
if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}
 
  ?>
<main class="background-dashboard">
	<section>
	</section>
</main>
<?php include('footer.php') ?>	