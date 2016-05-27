 <script>
	<!-- CHART.JS -->
	
    Chart.defaults.global.pointHitDetectionRadius = 1;
    
    Chart.defaults.global.scaleFontColor = "#FFF";
    
    Chart.defaults.global.scaleLineColor = "#CCC";
	
	Chart.defaults.global.scaleGridLineColor = "#CCC";
    
    var lineChartData = {
        labels: [<?php
        		if ($type == 'forecast') {
        			$breakLoop = $time;
        			foreach ($forecast['hourly']['data'] as $hourlyForecast) {
        				if ($breakLoop == 0){
							break;
						}
						else{
							if ($breakLoop != $time){
								echo ",";
							}
							$breakLoop--;
						}
        			
        				// forecast.io time
						$forecast_time_epoch = $hourlyForecast['time'];
						$dt = new DateTime("@$forecast_time_epoch");
						$forecast_time = date('"H:i"', $forecast_time_epoch);
						echo $forecast_time ;
        			}
        			
        		}
        		else {
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
            }
        ?>],
        datasets: [{
            label: "<?php echo $type;?>",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php
            	if ($type == 'forecast'){
						foreach ($forecast['hourly']['data'] as $hourlyForecast) {
							switch ($data){ // depending on chart type, echo values to chart script
								case 'Precipitation Probability':
									echo $hourlyForecast['precipProbability'].',';
									break;
								case 'Wind Speed':
									echo $hourlyForecast['windSpeed'].',';
									break;
								case 'Humidity':
									echo $hourlyForecast['humidity'].',';
									break;
								case 'Cloud Cover':
									echo $hourlyForecast['cloudCover'].',';
									break;
								default: 
									$forecast_temp_raw = ($hourlyForecast['temperature'] - 32) * 5/9;
									$forecast_temp = number_format($forecast_temp_raw, 2, '.', '');
									echo $forecast_temp.','; // default to temp
									break;
							}
						}
						echo '0';
					}
					else{
						foreach ($stations['observations']['data'] as $station) {
							switch ($data){ // depending on chart type, echo values to chart script
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
									echo $station['air_temp'].','; // default to temp
									break;
							}
						}
						echo '0';
					}
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