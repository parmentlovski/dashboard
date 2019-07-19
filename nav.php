

</head>
<body>
<?php 
global $db;

$idPp = $_SESSION['user']['profil_img'];


$sql_pp = "SELECT url_img FROM profil_img WHERE id = '$idPp'";
$sth_pp = $db->prepare($sql_pp);
$sth_pp->bindParam(':id', $idPp, PDO::PARAM_INT);
$sth_pp->execute();
$result_pp = $sth_pp->fetchAll(PDO::FETCH_ASSOC); 


?>
<section class="top-dashboard">
	<h1>BESANCON NEW COWTE</h1>
</section>
 <aside class="nav-dashboard">

 	<nav>
		 <?php if (isset($_SESSION['user'])) : ?>
		<!-- <h2><a href="home.php">Besançon New Cowté</a></h2> -->
		<img class="logo-bnc" src="../assets/img/logobnc.png" alt="Logo du site">
 			<ul>
 				<li class="profile_info">
				 <strong><?php echo $_SESSION['user']['username']; ?></strong><br>
				 <a href="test.php"> <img id="img" src="<?php echo$result_pp[0]['url_img'] ;?>"></a>
 				</li>
 				<li><a href="graph.php"><i class="fas fa-chart-pie"></i>Statistics</a></li>
 				<li><a href="create_user.php"><i class="fas fa-users-cog"></i> Add user</a></li>
 				<li><a href="create_pp.php"><i class="fas fa-image"></i> Add pictures profil</a></li>
 				<li><a href="create_notif.php"><i class="fas fa-football-ball"></i> Add notif</a></li>
 				<li><a href="create_season.php"><i class="fas fa-history"></i> Add season</a></li>
 				<li><a href="home.php?logout='1'">
 						<i class="fas fa-sign-out-alt">
						 </i>Logout
					 </a>
				</li>
			 </ul>
			
 		<?php endif ?>
	 </nav>
 </aside>

 </aside>