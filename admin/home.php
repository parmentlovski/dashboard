<?php
include('../functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="assets/vendor/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Graduate&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>

<body>

	<?php include('../nav.php') ?>

	<section class="graphique container-fluid">
		<h1>Les statistiques du club</h1>
		<div class="container">
			<div class="row">
            <?php $sql_sco = "SELECT SUM(places_reservees) AS places_reservees, planning.jour_event, places_necessaires FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY response_parent.jour_event DESC LIMIT 4";
        $sth_sco = $db->prepare($sql_sco);
        $sth_sco->execute();
        $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);
        $result_reverse = array_reverse($result_sco);
        var_dump($result_reverse[0]['jour_event']);
        var_dump($result_reverse[1]['jour_event']);
        var_dump($result_reverse[2]['jour_event']);
        var_dump($result_reverse[3]['jour_event']);

        echo $result_reverse[0]['jour_event'];


        ?>

        <canvas id="canvas2"></canvas>

        <script>
            var barChartData = {
                labels: ['<?php echo $result_reverse[0]['jour_event']; ?>', '<?php echo $result_reverse[1]['jour_event']; ?>', '<?php echo $result_reverse[2]['jour_event']; ?>', '<?php echo $result_reverse[3]['jour_event']; ?>'],
                datasets: [{
                    label: 'Places réservées',
                    data: [<?php addition(); ?>],
                    backgroundColor: [
                        'green',
                        'green',
                        'green',
                        'green'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }, {
                    label: 'Places disponibles',
                    data: [<?php soustract(); ?>],
                    fontSize: 40,
                    defaultFontSize: 40,
                    backgroundColor: [
                        'red',
                        'red',
                        'red',
                        'red'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            
            window.onload = function() {
                var ctx2 = document.getElementById('canvas2').getContext('2d');
                window.myBar = new Chart(ctx2, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        title: {
                            display: true,
                            fontSize: 35,
                            text: 'Places disponibles sur les 4 prochains évènements'
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        responsive: true,
                        scales: {
                            xAxes: [{
                                stacked: true,
                                // barThickness: 6,
                                // maxBarThickness: 8,
                                barPercentage: 0.4,
                                ticks: {
                                    fontSize: 40
                                }

                            }],
                            yAxes: [{
                                stacked: true
                            }],

                        }
                    }
                });
            };
        </script>

        <?php
        $sql_sco = "SELECT username, SUM(reponse) FROM users 
         LEFT JOIN response_parent ON response_parent.id_user = users.id
         WHERE reponse = 1 GROUP BY id_user ORDER BY SUM(reponse) DESC LIMIT 5";
        $sth_sco = $db->prepare($sql_sco);
        $sth_sco->execute();
        $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result_sco);
        ?>

        <canvas id="myChart1"></canvas>
        <script>
           var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var color = Chart.helpers.color;
		var horizontalBarChartData = {
			labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'classement',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor()
                    ]
                }, {
                    label: 'ok',
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.blue,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor()
                    ]
                }]
            };

            window.onload = function() {
                var ctx = document.getElementById('myChart1').getContext('2d');
                window.myHorizontalBar = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: horizontalBarChartData,
                    options: {
                        elements: {
                            rectangle: {
                                borderWidth: 2
                            }
                        },
                        responsive: true,
                        legend: {
                            position: 'right'
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Horizontal Bar Chart'
                        }
                    }
                });
            };
        </script>

	</section>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="assets/vendor/js/mdb.min.js"></script>

</body>

</html>