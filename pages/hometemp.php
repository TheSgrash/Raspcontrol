<?php

namespace lib;

use lib\Uptime;
use lib\Memory;
use lib\CPU;
use lib\Storage;
use lib\Network;
use lib\Rbpi;
use lib\Users;
use lib\Temp;

$uptime = Uptime::uptime();
$temps = Temp::historical_heat();

function icon_alert($alert) {
    echo '<i class="icon-';
    switch ($alert) {
        case 'success':
            echo 'ok';
            break;
        case 'warning':
            echo 'warning-sign';
            break;
        default:
            echo 'exclamation-sign';
    }
    echo '"></i>';
}

$LABELS=$VALUES="";
$TEMPMIN=50;
$TEMPMAX=0;

$number = count($temps);

$TOTAL_MAX = 4*36; // 36 hours
$start = 0;
$total = $number;
if($number > $TOTAL_MAX){
	$start = $number - $TOTAL_MAX;
}
// remove double (or more) spaces for all items
//foreach ($temps as &$item) {
for($i = $start; $i < $total; $i++){
	$item = $temps[$i];
	$item = preg_replace('/[[:blank:]]+/', ' ', $item);
	$item = trim($item);
	$items = explode(" ", $item);
	$val = $items[2]/1000;
	$LABELS .= "'".$items[0]." ".substr($items[1],0,5)."', ";
	$VALUES .= "'$val', ";
	if($val < $TEMPMIN) $TEMPMIN=$val;
	if($val > $TEMPMAX) $TEMPMAX=$val;
}
//$LABELS.=$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS.$LABELS;
//$VALUES.=$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES.$VALUES;
$LABELS=rtrim($LABELS,", ");
$VALUES=rtrim($VALUES,", ");
echo "<center><b>MAX: </b>$TEMPMAX"."°C<br><b>MIN: </b>$TEMPMIN"."°C</center><br>";
$TEMPMIN-=1;
$TEMPMAX+=1;
$TICKS = 0.25;
if($TEMPMAX-$TEMPMIN > 10)
	$TICKS = 0.5;
elseif($TEMPMAX-$TEMPMIN > 15)
	$TICKS = 1;
?>
<div class="container details">

	<canvas id="tempChart" width="1300" height="700"></canvas>
	<script>
	chartColors = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)'
	};
		
	var ctx = document.getElementById("tempChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: [<?php echo $LABELS;?>],
			datasets: [{
				label: 'Home Temperatures',
				data: [<?php echo $VALUES;?>],
				cubicInterpolationMode: 'default',
				fill: false,
				backgroundColor: chartColors.blue,
				borderColor: chartColors.blue
			}]
		},
		options: {
			responsive: true,
			legend: {
				position: 'bottom',
			},
			hover: {
				mode: 'index'
			},
			scales: {
				xAxes: [{
					display: true
				}],
				yAxes: [{
					display: true,
//					ticks: {
//						suggestedMin: <?php echo $TEMPMIN ?>,
//						suggestedMax: <?php echo $TEMPMAX ?>,
//						stepSize: <?php echo $TICKS ?>
//					}
				}]
			},
			title: {
				display: true,
				text: 'Home Temperatures'
			}
		}
	});
	</script>
</div>
