<title>Welcome to Besançon New Cowté</title>
</head>
<body>

<?php
include('functions.php');
include('header.php');


if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
?>

<?php include('nav_user.php'); 
include('pop-up-pp.php')
?>
<main>
  
  <h1>Home page</h1>


<?php 

$sql = "SELECT SUM(places_reservees) as nombre_inscrit, planning.lieu, planning.jour_event, places_necessaires, places_necessaires - SUM(places_reservees) AS place_disponible FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY planning.jour_event DESC LIMIT 4";
$sth = $db->prepare($sql);
$sth->execute();
$nextEvent = $sth->fetchAll(PDO::FETCH_ASSOC);
$nextEventReverse = array_reverse($nextEvent);

?>
<div class="next">

  <ul>
    <li><?php echo $nextEventReverse[0]['jour_event'] ;?></li>
    <li><?php echo $nextEventReverse[0]['lieu'] ;?></li>
    <li><?php echo $nextEventReverse[0]['nombre_inscrit'] ;?></li>
  </ul>
</div>
<div class="next">

  <ul>
  <li><?php echo $nextEventReverse[1]['jour_event'] ;?></li>
    <li><?php echo $nextEventReverse[1]['lieu'] ;?></li>
    <li><?php echo $nextEventReverse[1]['nombre_inscrit'] ;?></li>
  </ul>
</div>
<div class="next">

  <ul>
    <li></li>
    <li></li>
    <li></li>
  </ul>
</div>
<div class="next">

  <ul>
    <li></li>
    <li></li>
    <li></li>
  </ul>
</div>

</main>


