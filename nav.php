<section class="top-dashboard">
    <img src="../assets/img/fanion.png" alt="Logo du site">
    <h2><a href="home.php">Besançon New Cowté</a></h2>
    <p><a href="home.php?logout='1'">
    <i class="fas fa-sign-out-alt"></i>
    </a></p>
</section>

<aside class="nav-dashboard">

		<nav>
			<?php if (isset($_SESSION['user'])) : ?>
				<ul>
					<li class="profile_info">
						<img src="../assets/img/casque.png">
						<strong><?php echo $_SESSION['user']['username']; ?></strong>
						<i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                    </li>
                    <li><a href="graph.php">Statistics</a></li>
					<li><a href="create_user.php"> + Add user</a></li>
					<li><a href="create_notif.php"> + Add notif</a></li>
                    <li><a href="create_season.php"> + Add season</a></li>
				</ul>
			<?php endif ?>
		</nav>
	</aside>