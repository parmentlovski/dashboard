<?php
include('../functions.php');
include('../header.php');


if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

addition();
?>

<title>Statistics</title>
</head>
<body>

    <main>


        <?php
        include('../nav.php');
        ?>
        <?php
        function addition()
        {

            global $db, $date_event, $result_sco;

            $sql_sco = "SELECT `jour_event`, SUM(`places_reservees`) FROM response_parent GROUP BY `jour_event` ORDER BY `jour_event` DESC LIMIT 4";
            $sth_sco = $db->prepare($sql_sco);
            $sth_sco->bindParam(':jour_event', $date_event, PDO::PARAM_STR);
            $sth_sco->execute();
            $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);
            $result_reverse = array_reverse($result_sco);



            // $sql1 = "SELECT places_necessaires FROM planning";
            // $sthpN = $db->prepare($sql1);
            // $sthpN->execute();
            // $placeLimite = $sthpN->fetch(PDO::FETCH_ASSOC);

            for ($i = 0; $i < sizeof($result_reverse); $i++) {

                //echo de mes places additionné selon les dates
                echo $result_reverse[$i]['SUM(`places_reservees`)'] . ',';


                //echo du calcul de pourcentage entre le nombre de places prise et le nombre de place necessaire par date
                // echo (($result_sco[$i]['SUM(`places`)'] * 100) / $placeLimite['places_necessaires'].',');
            }
        }

        function soustract()
        {

            global $db, $date_event, $result_sco, $difference, $i;

            // $igali = "SELECT places_reservees, places_necessaires FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY planning.jour_event ORDER BY `jour_event` DESC LIMIT 4";

            // $sql_sco = "SELECT `jour_event`, SUM(`places_reservees`) FROM response_parent GROUP BY `jour_event` ORDER BY `jour_event` DESC LIMIT 4";
            // $sth_sco = $db->prepare($sql_sco);
            // $sth_sco->bindParam(':jour_event', $date_event, PDO::PARAM_STR);
            // $sth_sco->execute();
            // $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);
            // $result_reverse = array_reverse($result_sco);

            $sql_sco = "SELECT SUM(places_reservees) AS places_reservees, planning.jour_event, places_necessaires FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY response_parent.jour_event DESC LIMIT 4";
            $sth_sco = $db->prepare($sql_sco);
            $sth_sco->execute();
            $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);
            $result_reverse = array_reverse($result_sco);



            // var_dump( $result_sco[0]['SUM(`places`)']);

            // var_dump($placeLimite);


            for ($i = 0; $i < sizeof($result_reverse); $i++) {

                // var_dump($result_sco[$i]["SUM(`places`)"]); => Somme des places réservées !!!      LIGNE A NE PAS SUPPRIMER        !!!!

                $difference = $result_reverse[$i]["places_necessaires"] -  $result_reverse[$i]["places_reservees"];

                echo $difference . ',';
                // echo('<br>(places nécessaires)'. $placeLimite[$i]["places_necessaires"] .'   -   (places réservées) '.$result_sco[$i]["SUM(`places`)"] . '=' . $difference . '<br>'); 
            }
        }


        ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

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
        // var_dump($result_sco[0]['username']);
        
        ?>

        <canvas id="bar-chart-horizontal"> </canvas>
        <script>
            new Chart(document.getElementById("bar-chart-horizontal"), {
                type: 'horizontalBar',
                data: {
                    labels: ['<?php echo $result_sco[0]['username']; ?>', '<?php echo $result_sco[1]['username']; ?>', '<?php echo $result_sco[2]['username']; ?>', '<?php echo $result_sco[3]['username']; ?>', '<?php echo $result_sco[4]['username']; ?>'],
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data:[<?php echo $result_sco[0]['SUM(reponse)']; ?>, <?php echo $result_sco[1]['SUM(reponse)']; ?>, <?php echo $result_sco[2]['SUM(reponse)']; ?>, <?php echo $result_sco[3]['SUM(reponse)']; ?>, <?php echo $result_sco[4]['SUM(reponse)']; ?>, 0]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Predicted world population (millions) in 2050'
                    }
                }
            });
        </script>



   <?php include('../footer.php'); ?>