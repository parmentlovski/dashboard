<?php
include('functions.php');
include('header.php');


if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

addition();
?>

    <canvas id="myChart" width="100" height="100">    </canvas>

        <?php

        $sql_graph = "SELECT places_necessaires FROM planning WHERE places_necessaires";
        $sth_graph = $db->prepare($sql_graph);
        $sth_graph->execute();
        $result_graph = $sth_graph->fetchAll(PDO::FETCH_ASSOC);

        for ($i1 = 0; $i1 < sizeof($result_graph); $i1++) {
            $graph = 0;

            $graph += $result_graph[$i1]["places_necessaires"];
            echo ($result_graph[$i1]['places_necessaires'] . ',');
        }

        // function pourcent()
        // {

        //     global $db, $date_event, $result_sco;

        //     $sql_sco = "SELECT `jour_event`, SUM(`places_reservees`) FROM response_parent GROUP BY `jour_event`";
        //     $sth_sco = $db->prepare($sql_sco);
        //     $sth_sco->bindParam(':jour_event', $date_event, PDO::PARAM_STR);
        //     $sth_sco->execute();
        //     $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);


        //     $sql1 = "SELECT places_necessaires FROM planning";
        //     $sthpN = $db->prepare($sql1);
        //     $sthpN->execute();
        //     $placeLimite = $sthpN->fetch(PDO::FETCH_ASSOC);

        //     for ($i = 0; $i < sizeof($result_sco); $i++) {
                
        //         //echo de mes places additionné selon les dates
        //         echo $result_sco[$i]['SUM(`places_reservees`)'].',';


        //         //echo du calcul de pourcentage entre le nombre de places prise et le nombre de place necessaire par date
        //         echo (($result_sco[$i]['SUM(`places`)'] * 100) / $placeLimite['places_necessaires'].',');
        //     }

        // }


        function addition()
        {

            global $db, $date_event, $result_sco;

            $sql_sco = "SELECT `jour_event`, SUM(`places_reservees`) FROM response_parent GROUP BY `jour_event`";
            $sth_sco = $db->prepare($sql_sco);
            $sth_sco->bindParam(':jour_event', $date_event, PDO::PARAM_STR);
            $sth_sco->execute();
            $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);


            $sql1 = "SELECT places_necessaires FROM planning";
            $sthpN = $db->prepare($sql1);
            $sthpN->execute();
            $placeLimite = $sthpN->fetch(PDO::FETCH_ASSOC);

            for ($i = 0; $i < sizeof($result_sco); $i++) {
                
                //echo de mes places additionné selon les dates
                echo $result_sco[$i]['SUM(`places_reservees`)'].',';


                //echo du calcul de pourcentage entre le nombre de places prise et le nombre de place necessaire par date
                echo (($result_sco[$i]['SUM(`places_reservees`)'] * 100) / $placeLimite['places_necessaires'].',');
            }

        }

        function soustract()
        {

            global $db, $date_event, $i;
            $sql_graph = "SELECT places_necessaires FROM planning WHERE places_necessaires";
            $sth_graph = $db->prepare($sql_graph);
            $sth_graph->execute();
            $result_graph = $sth_graph->fetchAll(PDO::FETCH_ASSOC);

            $sql_sco = "SELECT `jour_event`, SUM(`places_reservees`) FROM response_parent GROUP BY `jour_event`";
            $sth_sco = $db->prepare($sql_sco);
            $sth_sco->bindParam(':jour_event', $date_event, PDO::PARAM_STR);
            $sth_sco->execute();
            $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);
    
            for ($i1 = 0; $i1 < sizeof($result_graph); $i1++) {
                $graph = 0;
    
                $graph += $result_graph[$i1]["places_necessaires"];
                echo ($result_graph[$i1]['places_necessaires'] . ',');
            }

            for ($j = 0; $j < sizeof($result_sco); $j++) {
                echo $result_sco[$j]['SUM(`places_reservees`)'].',';
                //echo de mes places additionné selon les dates
                echo $result_sco[$j]['SUM(`places_reservees`)'].',';

            }

        }
        soustract()

        ?>
        <script>
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                         data: [<?php addition(); ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
              
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>

    <canvas id="canvas"></canvas>

    <script>
        var barChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Places réservées',
                data: [<?php addition(); ?>],
                backgroundColor: [
                    'green',
                    'green',
                    'green',
                    'green',
                    'green',
                    'green',
                    'green'

                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'

                ],
                borderWidth: 1
            }, {
                label: 'Places nécessaires',
                data: [<?php
                        $graph = 0;
                        for ($i = 0; $i < sizeof($result_graph); $i++) {
                            $graph += $result_graph[$i]["places_necessaires"];
                            echo ($result_graph[$i]['places_necessaires'] . ',');
                        } ?>],
                backgroundColor: [
                    'red',
                    'red',
                    'red',
                    'red',
                    'red',
                    'red',
                    'red'

                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1



            }]

        };
        window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    title: {
                        display: true,
                        text: 'Chart.js Bar Chart - Stacked'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        };

        document.getElementById('randomizeData').addEventListener('click', function() {
            barChartData.datasets.forEach(function(dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });
            });
            window.myBar.update();
        });
    </script>
    
  <?php include('footer.php') ;?>