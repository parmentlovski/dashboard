<section class="top-dashboard">
    <img src="../assets/img/fanion.png" alt="Logo du site">
    <h2><a href="home.php">Besançon New Cowté</a></h2>
    <div class="positionnement-notif">
        <p>
            <a href="notification.php" class="nav-link waves-effect waves-light">1
                <i class="fas fa-envelope">
                </i>
            </a>
        </p>
        <p><a href="index.php?logout='1'">
                <i class="fas fa-sign-out-alt"></i>
            </a></p>
        <p>
    </div>
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
                <li><a href="index.php"> Home</a></li>
                <li><a href="notification.php"> Notifications</a></li>
            </ul>
        <?php endif ?>
    </nav>
</aside>