
<canvas id="myChart" class="offset-3 col-9"> </canvas>

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

//     $sql_sco = "SELECT `jour_event`, SUM(`places`) FROM response_parent GROUP BY `jour_event`";
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
//         echo $result_sco[$i]['SUM(`places`)'].',';


//         //echo du calcul de pourcentage entre le nombre de places prise et le nombre de place necessaire par date
//         // echo (($result_sco[$i]['SUM(`places`)'] * 100) / $placeLimite['places_necessaires'].',');
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
    // $placeLimite = $sthpN->fetch(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($result_sco); $i++) {

        //echo de mes places additionné selon les dates
        echo $result_sco[$i]['SUM(`places_reservees`)'] . ',';


        //echo du calcul de pourcentage entre le nombre de places prise et le nombre de place necessaire par date
        // echo (($result_sco[$i]['SUM(`places`)'] * 100) / $placeLimite['places_necessaires'].',');
    }
}

function soustract()
{

    global $db, $date_event, $result_sco, $difference, $i;


    $sql_sco = "SELECT `jour_event`, SUM(`places_reservees`) FROM response_parent GROUP BY `jour_event`";
    $sth_sco = $db->prepare($sql_sco);
    $sth_sco->bindParam(':jour_event', $date_event, PDO::PARAM_STR);
    $sth_sco->execute();
    $result_sco = $sth_sco->fetchAll(PDO::FETCH_ASSOC);


    $sql1 = "SELECT places_necessaires FROM planning";
    $sthpN = $db->prepare($sql1);
    $sthpN->execute();
    $placeLimite = $sthpN->fetchAll(PDO::FETCH_ASSOC);

    // var_dump( $result_sco[0]['SUM(`places`)']);

    // var_dump($placeLimite);

    for ($i = 0; $i < sizeof($result_sco); $i++) {

        // var_dump($result_sco[$i]["SUM(`places`)"]); => Somme des places réservées !!!      LIGNE A NE PAS SUPPRIMER        !!!!


            $difference = $placeLimite[$i]["places_necessaires"] -  $result_sco[$i]["SUM(`places_reservees`)"];
            echo $difference.',';
            // echo('<br>(places nécessaires)'. $placeLimite[$i]["places_necessaires"] .'   -   (places réservées) '.$result_sco[$i]["SUM(`places`)"] . '=' . $difference . '<br>'); 
    }




}
 $test = "SELECT SUM(places_reservees) as nombre_inscrit, planning.jour_event, places_necessaires, places_necessaires - SUM(places_reservees) AS place_disponible FROM planning LEFT JOIN response_parent ON response_parent.jour_event = planning.jour_event GROUP BY planning.jour_event"

?>
<!--  <script>
            /*var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                         data: [<?php //addition(); 
                                ?>],
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
            });*/
        </script> -->

<canvas id="canvas" class="offset-3 col-9"></canvas>

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
                'green'

            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }, {
            label: 'Places nécessaires',
            data: [<?php soustract();?>],
            backgroundColor: [
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

 
    </script>

    