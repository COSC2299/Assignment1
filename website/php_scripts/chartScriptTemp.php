<script>

    Chart.defaults.global.pointHitDetectionRadius = 1;
    
    var lineChartData = {
        labels: [<?php
        		$breakLoop = $time * 2;
        		foreach ($stations['observations']['data'] as $station) {
        		//for ($i=0; $i<24; $i++){
        			if ($breakLoop == 0){
        				break;
        			}
        			else{
        				if ($breakLoop != $time*2){
        					echo ",";
        				}
        				$breakLoop--;
        			}
        			$date = $station['local_date_time_full'];
					$year = substr($date, 0, 4);
					$month = substr($date, 4, 2);
					$day = substr($date, 6, 2);
					$hour = substr($date, 8, 2);
					$minute = substr($date, 10, 2);
            	echo '"'.$hour.':'.$minute.'"';
            }
        ?>],
        datasets: [{
            label: "Temperature",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php
            	foreach ($stations['observations']['data'] as $station) {
            		switch ($type){
            			case 'Rain Fall Since 9am':
            				echo str_replace("-", "0", $station['rain_trace']).',';
            				break;
            			case 'Wind Speed':
            				echo str_replace("-", "0", $station['wind_spd_kmh']).',';
            				break;
            			case 'Gust Speed':
            				echo str_replace("-", "0", $station['gust_kmh']).',';
            				break;
            			case 'Pressure':
            				echo str_replace("-", "0", $station['press']).',';
            				break;
            			case 'Relative Humidity':
            				echo str_replace("-", "0", $station['rel_hum']).',';
            				break;
            			default: 
            				echo $station['air_temp'].',';
            				break;
            		}
            	}
            	echo '0';
            ?>]
        }]
    };

    window.onload = function() {


        var ctx2 = document.getElementById("chart2").getContext("2d");
        window.myLine = new Chart(ctx2).Line(lineChartData, {
            responsive: true
        });
    };
    </script>