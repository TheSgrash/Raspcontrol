<?php

namespace lib;

use lib\Services;

$services = Services::services();

function label_service($status) {
    echo '<span class="label label-';
    switch ($status) {
        case '+':
            echo 'success';
            break;
        case '?':
            echo 'important';
            break;
        default:
            echo 'warning';
    }
    echo '">';
    switch ($status) {
        case '+':
            echo 'Running';
            break;
        case '?':
            echo 'Errore';
            break;
        default:
            echo 'Stoppato';
    }
    echo '</span>';
}
?>

<div class="container details">
    <table>
        <tr class="services" id="check-services">
            <td class="check" rowspan="<?php echo ($services[0]['tot']-$services[0]['scart']); ?>"><i class="icon-cog"></i> Servizi: <?php echo ($services[0]['tot']-$services[0]['scart']);?></td>
            <?php
            $tot = sizeof($services)-$services[0]['scart']-1;
            for ($i = 1; $i <= $tot; $i++) {
                echo '<td class="icon" style="padding-left: 10px;">';
                echo '<a data-rootaction="changeservicestatus" data-service-name="' . $services[$i]["name"] . '" class="rootaction" href="javascript:;">';
                echo label_service($services[$i]['status']), '</a></td>
            <td class="infos">', $services[$i]['name'], '</td>
          </tr>
          ', ($i == sizeof($hdd) - 1) ? null : '<tr class="service">';
            }
            ?>
        <tr>
			<td colspan="3"><hr></td>
		</tr>
        <tr class="services" id="check-services">
            <td class="check" rowspan="<?php echo $services[0]['scart']; ?>"><i class="icon-cog"></i> Altri Servizi: <?php echo $services[0]['scart'];?></td>
            <?php
            $tot = sizeof($services)-$services[0]['scart'];
            for ($i = $tot+1; $i <= $services[0]['tot']; $i++) {
                echo '<td class="icon" style="padding-left: 10px;">';
                echo '<a data-rootaction="changeservicestatus" data-service-name="' . $services[$i]["name"] . '" class="rootaction" href="javascript:;">';
                echo label_service($services[$i]['status']), '</a></td>
            <td class="infos">', $services[$i]['name'], '</td>
          </tr>
          ', ($i == sizeof($hdd) - 1) ? null : '<tr class="service">';
            }
            ?>
</table>
</div>
