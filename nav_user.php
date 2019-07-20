
  <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
<aside class="nav-dashboard">
    <?php
    global $db;

    $idPp = $_SESSION['user']['profil_img'];


    $sql_pp = "SELECT url_img FROM profil_img WHERE id = '$idPp'";
    $sth_pp = $db->prepare($sql_pp);
    $sth_pp->bindParam(':id', $idPp, PDO::PARAM_INT);
    $sth_pp->execute();
    $result_pp = $sth_pp->fetchAll(PDO::FETCH_ASSOC);


    ?>
    <nav>
        <?php if (isset($_SESSION['user'])) :


            ?>
            <ul>
                <li class="profile_info">
                    <strong><?php echo $_SESSION['user']['username']; ?></strong><br>
                    <a href="test.php"> <img id="img" src="<?php echo $result_pp[0]['url_img']; ?>"></a>
                </li>
                <li><a href="index.php"><i class="fas fa-home"></i>Home</a></li>
                <li><a href="update.php"><i class="fas fa-cogs"></i>Settings</a></li>
                <li><a href="notification.php"> <i class="fas fa-envelope">
                        </i>Notifications</a></li>
                <li><a href="index.php?logout='1'">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a></li>
            </ul>

			 <img class="logo-bnc" src="../assets/img/logobnc.png" alt="Logo du site">


        <?php endif ?>
    </nav>
</aside>