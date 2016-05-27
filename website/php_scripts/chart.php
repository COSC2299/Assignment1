    <div id="canvas-holder2">
        <canvas id="chart2" width="450" height="200"></canvas>
    </div>
    <!-- CHART.JS -->
    
    <br>
    <table style='width:100%; margin:auto;'>
		 <tr>
			<td>
				<?php if($time > 6){ ?>
					<a href="city_chart.php?c=<?php echo $selectedCity; ?>&s=<?php echo $selectedState; ?>&id=<?php echo $id;?>&sID=<?php echo $sID; ?>&data=<?php echo $data; ?>&time=<?php echo (Intval($time) - 6); ?>&type=<?php echo $type;?>">Zoom In</a>
				<?php } ?>
			</td>
			<td>
				<?php if($time < $numEntries) { ?>
					<a href="city_chart.php?c=<?php echo $selectedCity; ?>&s=<?php echo $selectedState; ?>&id=<?php echo $id;?>&sID=<?php echo $sID; ?>&data=<?php echo $data; ?>&time=<?php echo (Intval($time) + 6); ?>&type=<?php echo $type;?>">Zoom Out</a>
				<?php } ?>
			</td>
		</tr>
	</table>