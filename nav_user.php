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
                    <a href="test.php"> <img id="img" src="<?php echo$result_pp[0]['url_img'] ;?>"></a>
                    <strong><?php echo $_SESSION['user']['username']; ?></strong>
                    <i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="update.php">Settings</a></li>
                <li><a href="notification.php"> Notifications</a></li>
            </ul>
    
        <?php endif ?>
    </nav>
</aside>