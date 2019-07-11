<?php
include('functions.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Home</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="assets/vendor/css/mdb.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <link rel="stylesheet" type="text/css" href="/assets/css/style.css">

</head>

<body>

  <!--Navbar -->
  <nav class="mb-1 navbar navbar-expand-lg navbar-dark lighten-1 custom-nav">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555" aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-555">

      <ul class="navbar-nav ml-auto nav-flex-icons">
        <li class="nav-item pt-1">
          <a href="notification.php" class="nav-link waves-effect waves-light">1
            <i class="fas fa-envelope">
            </i>
          </a>
        </li>
        <li class="nav-item username-connect"><?php if (isset($_SESSION['user'])) : ?>
            <strong><?php echo $_SESSION['user']['username']; ?></strong>

            <small>

              <br>

            </small>

          <?php endif ?></li>
        <li class="nav-item avatar dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="assets/img/user_profile.png" class="rounded-circle z-depth-0">

          </a>
          <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-55">
            <a class="dropdown-item" href="#">Mon profil</a>
            <a href="index.php?logout='1'" style="color: red;">logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!--/.Navbar -->

  <div class="header">
    <h2>Notifications</h2>

  </div>

  <div class="notification_info">
    <form method="post" action="notification.php">
      <p>Pouvez vous emmener des personnes cette semaine ?
        <input type='checkbox' id='oui' name='reponseOui' value='oui'>
        <label for="reponseOui">Oui</label>
        <input type='checkbox' id='non' name='reponseNon' value='non'>
        <label for="reponseNon">Non</label>
        <label for="jour_event">Date de l'évènement</label>
        <select name="jour_event" id="jour_event" class="jour_event">
            <?php

            $sql = "SELECT jour_event, lieu FROM planning LIMIT 4";
            $sth = $db->prepare($sql);
            $sth->bindParam(':jour_event', $dateEvent, PDO::PARAM_STR);
            $sth->bindParam(':lieu', $lieuMatch, PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
              global $placesDispo;
              // output data of each row
              foreach ($result as $planning) {
                // ?><option><?php echo $planning["jour_event"];?></option><?php
              }
            }
            ?>
          </select>

        <div id="block-reponse" class="dn">
          <label for='places_reservees'>Combien de personnes ?</label>
          <input class="test" type='number' id='places_reservees' name='places_reservees' min="0" max="">
        </div>
        <button type="submit" class="btn" name="reponse_btn">reponse</button>
        <?php echo display_error(); ?>
        <?php echo display_validation(); ?>
        
        

        <?php
          $sqlC = "SELECT SUM(places_reservees) as nombre_inscrit, planning.jour_event, places_necessaires, places_necessaires - SUM(places_reservees) AS place_disponible FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY planning.jour_event ";
          $sthC = $db->prepare($sqlC);
          $sthC->execute();
          $countPlaces = $sthC->fetchAll(PDO::FETCH_ASSOC);
          // $countPlacesArray = $scountPlaces[0]['place_disponibles'];
        ?>
        <script> var tableau_date = <?php echo json_encode($countPlaces) ?>; 
        // console.log(tableau_date[i]['place_disponible']);

        date = document.querySelector('.jour_event');
        date.addEventListener('change', function(e) {
          for (var i = 0; i < tableau_date.length; i++) {
            console.log(i);
             if(tableau_date[i]['jour_event'] == date.value){
              place_disponible = tableau_date[i]['place_disponible'];
              if(place_disponible === null){
                place_disponible = tableau_date[i]['places_necessaires'];
              }
              else if(place_disponible < 0){
                place_disponible = 0;
              } 

                input = document.querySelector('.test');
                input.setAttribute('max',place_disponible);
               break;
             }
          }
        });

        </script>

    </form>

    <?php
            print_r($result);

    showNotif();; ?>


  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script type="text/javascript" src="assets/vendor/js/mdb.min.js"></script>
  <script type="text/javascript" src="assets/js/script.js"></script>


</body>

</html>