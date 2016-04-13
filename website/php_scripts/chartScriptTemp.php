<script>

    Chart.defaults.global.pointHitDetectionRadius = 1;
    Chart.defaults.global.customTooltips = function(tooltip) {

        var tooltipEl = $('#chartjs-tooltip');

        if (!tooltip) {
            tooltipEl.css({
                opacity: 0
            });
            return;
        }

        tooltipEl.removeClass('above below');
        tooltipEl.addClass(tooltip.yAlign);

        var innerHtml = '';
        for (var i = tooltip.labels.length - 1; i >= 0; i--) {
        	innerHtml += [
        		'<div class="chartjs-tooltip-section">',
        		'	<span class="chartjs-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
        		'	<span class="chartjs-tooltip-value">' + tooltip.labels[i] + '</span>',
        		'</div>'
        	].join('');
        }
        tooltipEl.html(innerHtml);

        tooltipEl.css({
            opacity: 1,
            left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
            top: tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
            fontFamily: tooltip.fontFamily,
            fontSize: tooltip.fontSize,
            fontStyle: tooltip.fontStyle,
        });
    };
    var lineChartData = {
        labels: [<?php
        		$breakLoop = 0;
        		foreach ($stations['observations']['data'] as $station) {
        		//for ($i=0; $i<24; $i++){
        			if ($breakLoop == 24){
        				break;
        			}
        			else{
        				if ($breakLoop != 0){
        					echo ",";
        				}
        				$breakLoop++;
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
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php
            	foreach ($stations['observations']['data'] as $station) {
            	   echo $station['air_temp'].',';
            	}
            	echo '0';
            ?>]
        }]
    };

    window.onload = function() {
        var ctx1 = document.getElementById("chart1").getContext("2d");
        window.myLine = new Chart(ctx1).Line(lineChartData, {
        	showScale: false,
        	pointDot : true,
            responsive: true
        });

        var ctx2 = document.getElementById("chart2").getContext("2d");
        window.myLine = new Chart(ctx2).Line(lineChartData, {
            responsive: true
        });
    };
    </script>