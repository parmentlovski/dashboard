<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>

<body>
    <aside class="nav-dashboard">
        <?php
        global $db;

        $idUser = $_SESSION['user']['id'];

        $sql_infos = "SELECT * FROM users WHERE id='$idUser'";
        $sth_infos = $db->prepare($sql_infos);
        // $sth->bindParam(':status_event', 'en attente', PDO::PARAM_STR);
        $sth_infos->execute();
        $result_infos = $sth_infos->fetch(PDO::FETCH_ASSOC);


        $idPp = $_SESSION['user']['profil_img'];


        $sql_pp = "SELECT url_img FROM profil_img WHERE id = '$idPp'";
        $sth_pp = $db->prepare($sql_pp);
        $sth_pp->bindParam(':id', $idPp, PDO::PARAM_INT);
        $sth_pp->execute();
        $result_pp = $sth_pp->fetchAll(PDO::FETCH_ASSOC);


        ?>
        <nav>
            <?php if (isset($_SESSION['user'])) :

                $sql_c = "SELECT COUNT(status_event) FROM `planning` WHERE status_event = 'en attente'";
                $sth_c = $db->prepare($sql_c);
                $sth_c->execute();
                $result_c = $sth_c->fetchAll(PDO::FETCH_ASSOC);

                $nombreNotification = $result_c[0]["COUNT(status_event)"];

                $sql_total = "SELECT COUNT(DISTINCT(jour_event)) FROM `response_parent` WHERE id_user = '$idUser'";
                $sth_total = $db->prepare($sql_total);
                $sth_total->execute();
                $result_total = $sth_total->fetchAll(PDO::FETCH_ASSOC);

                $totalReponse = ($result_total[0]["COUNT(DISTINCT(jour_event))"]);
         
                $test = $totalReponse - $nombreNotification;

                // $sql_compte_non = "SELECT COUNT(jour_event) FROM `response_parent` WHERE id_user = '$idUser' AND reponse = 0";
                // $sth_compte_non = $db->prepare($sql_compte_non);
                // $sth_compte_non->execute();
                // $result_compte_non = $sth_compte_non->fetchAll(PDO::FETCH_ASSOC);
                // $reponseNon = $result_compte_non[0]["COUNT(jour_event)"];
                
                // $totalReponse = $reponseOui + $reponseNon;

                // echo $totalReponse;

                ?>
                <ul>
                    <li class="profile_info">
                        <strong><?php echo $result_infos['username']; ?></strong><br>
                        <a href="update.php">
                            <?php echo '<img src="' . $result_pp["url_img"] . '"; class="user-img rounded-circle z-depth-0">'; ?>
                        </a>
                    </li>
                    <li><a href="index.php"><i class="fas fa-home"></i>Home</a></li>
                    <li><a href="update.php"><i class="fas fa-cogs"></i>Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="notification.php"> <i class="fas fa-envelope">
                            </i>Notifications 
                            <?php if($test > 0) { 

                                echo '<span class="badge badge-danger">' . $test . '</span>' ; } ;?>
                            </a></li>
                    <li><a href="index.php?logout='1'">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </a></li>
                </ul>

                <?php 
               
                ;?>

                <!-- <img class="logo-bnc" src="../assets/img/logobnc.png" alt="Logo du site"> -->


            <?php endif ?>
        </nav>
    </aside>