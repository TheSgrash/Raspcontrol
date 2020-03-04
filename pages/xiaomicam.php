<?php

namespace lib;

use lib\Services;
use lib\Rbpi;

$servizio = "transmission";

echo '<div class="torrent">';
$url = "thesgrash.noip.me";
if(substr($_SERVER['REMOTE_ADDR'],0,10)=="192.168.1."){
	$url = Rbpi::internalIp();
}
/*
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
}*/
?>
<video style="background-color: black;" width="648" height="360" autoplay controls>
  <source src="http://192.168.1.36:8090/test.webm" type="video/webm">
  HTML5 video not supported.
</video>

</div>
