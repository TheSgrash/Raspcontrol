<?php

namespace lib;

use lib\Services;
use lib\Rbpi;

$servizio = "transmission";

$service = Services::getService($servizio);

function label_service($status) {
    echo '<span class="label label-';
    switch ($status) {
        case 'active':
            echo 'success';
            break;
        case 'inactive':
            echo 'warning';
            break;
        default:
            echo 'important';
    }
    echo '">';
    switch ($status) {
        case 'active':
            echo 'Running';
            break;
        case 'inactive':
            echo 'Stoppato';
            break;
        default:
            echo 'Errore';
    }
    echo '</span>';
}

echo '<div class="torrent">';
$url = "thesgrash.noip.me";
if(substr($_SERVER['REMOTE_ADDR'],0,10)=="192.168.1."){
	$url = Rbpi::internalIp();
}

if($service=="active"){
	echo 'Il servizio <i>'.$servizio.'</i> &egrave; <a data-rootaction="changeservicestatus" data-service-name="'.$servizio.'" href="javascript:;">';
	echo label_service($service), '</a><br>';
?>
<div style='border:1px solid black;width:1024px;height:400px;margin:auto;'>
	<iframe frameborder='0' src='http://<?php echo $url;?>:9091' width='1024px' height='400px'>
		Problema con l'iframe
	</iframe>
</div>
<?php 
} else {
	echo '<br><br><br><br>';
	echo 'Il servizio <i>'.$servizio.'</i> &egrave; <a data-rootaction="changeservicestatus" data-service-name="'.$servizio.'" class="rootaction" href="javascript:;">';
	echo label_service($service), '</a>';
	echo '<br><br><br><br><br>';
}
?>
</div>
