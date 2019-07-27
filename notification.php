<?php
include('functions.php');
include('header.php');
include('nav.php');

?>
<?php

?>



<title>Notifications</title>
</head>

<body>

  <div class="header">
    <h2>Notifications</h2>

  </div>

  <div class="notification_info">
    <form method="post" action="notification.php" class="form-create">
      <p>Pouvez vous emmener des personnes ?
        <input type='checkbox' id='oui' name='reponseOui' value='oui'>
        <label for="reponseOui">Oui</label>
        <input type='checkbox' id='non' name='reponseNon' value='non'>
        <label for="reponseNon">Non</label>
        <label for="jour_event">Date de l'évènement</label>
        <select name="jour_event" id="jour_event" class="jour_event">
          <option id="date" max = 0>Choisir date</option>
          <?php
          $statusSucces = "en attente";
          $sql = "SELECT jour_event, lieu FROM planning WHERE status_event = '$statusSucces'";
          $sth = $db->prepare($sql);
          $sth->bindParam(':jour_event', $dateEvent, PDO::PARAM_STR);
          $sth->bindParam(':lieu', $lieuMatch, PDO::PARAM_STR);
          $sth->execute();
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          if (count($result) > 0) {
            global $placesDispo;
            // output data of each row
            foreach ($result as $planning) {
              // 
              ?><option><?php echo $planning["jour_event"]; ?></option><?php
                                                                          }
                                                                        } else {
                                                                          array_push($errors, 'Aucun évènements en cours');
                                                                        }
                                                                        ?>
        </select>
                                                                   
        <?php
        $sqlC = "SELECT SUM(places_reservees) as nombre_inscrit, planning.jour_event, places_necessaires, places_necessaires - SUM(places_reservees) AS place_disponible FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY planning.jour_event ";
        $sthC = $db->prepare($sqlC);
        $sthC->execute();
        $countPlaces = $sthC->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($countPlaces);
        // $countPlacesArray = $scountPlaces[0]['place_disponibles'];
        ?>
        <script>
          var tableau_date = <?php echo json_encode($countPlaces) ?>;
          // console.log(tableau_date[i]['place_disponible']);

          date = document.querySelector('.jour_event'); // quand on sélectionne l'option des évènements
           date.addEventListener('change', function(e) { // et lorsque l'on change d'évènements
            for (var i = 0; i < tableau_date.length; i++) {
              // console.log(i);
              if (tableau_date[i]['jour_event'] == date.value) {
                place_disponible = tableau_date[i]['place_disponible'];
                if (place_disponible === null) {
                  place_disponible = tableau_date[i]['places_necessaires'];
                } else if (place_disponible < 0) {
                  place_disponible = 0;
                }
                input = document.querySelector('.test');
                input.setAttribute('max', place_disponible);
                break;
              }
            }
          });
        </script>
        <div id="block-reponse" class="dn">
          <label for='places_reservees'>Combien de personnes ?</label>
          <input class="test" type='number' id='places_reservees' name='places_reservees' min="0" max="">
        </div>
        <button type="submit" class="btn" name="reponse_btn">reponse</button>
        <?php echo display_error(); ?>
        <?php echo display_validation(); ?>

        <ul> Evènements auxquels vous n'avez pas répondu :
          <?php
        $idUser = $_SESSION['user']['id'];  
        $sql = "SELECT jour_event, lieu FROM `planning` WHERE status_event = 'en attente'
        EXCEPT
        (SELECT DISTINCT(planning.jour_event), lieu FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event WHERE id_user = '$idUser' AND status_event = 'en attente')";
        $sth = $db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($result as $row) {
          echo '<li> Le ' . $row['jour_event']. ' à ' . $row['lieu'] . '</li>';
        } ?>
        </ul>



    </form>

    <?php
    // print_r($result);

    // showNotif();; 
    ?>


  </div>
  </div>

  <?php include('footer.php'); ?>