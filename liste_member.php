<?php include('functions.php');
    include('header.php');
    // include('nav.php');
    if (!isAdmin()):
    if ("GET" === $_SERVER["REQUEST_METHOD"]) {
      // Renvoie l'utilisateur à la racine du serveur
      header("Location: /");
      // Met fin au script par mesure de sécurité
      die();
    }
    endif ; ?>

    <section>
        <table>
        
        <?php 
        $sql = "SELECT username, email, user_type, password FROM users";
        $sth = $db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row) {
            echo '<tr> <th>' . $row['username'] . 
            '<td>' . $row['email'] . '</td> 
            <td>' . $row['user_type'] . '</td> 
            <td>' . $row['password'] . '</td> 
            </th> </tr>' ;
        }


        ?>
    
        </table>
    </section>

    <?php include('footer.php');