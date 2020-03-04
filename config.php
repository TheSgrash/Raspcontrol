<?php
/*
 * To enable URL rewriting, please set the $rewriting variable on 'true'
 *
 * Ensure you have done every other steps described on
 * https://github.com/Bioshox/Raspcontrol/wiki/Enable-URL-Rewriting#configure-your-web-server
 */
$rewriting = false;

/*
 * Do NOT change the following lines
 */
error_reporting(0);
define('INDEX', './');
define('LOGIN', 'login.php');
//define('FILE_PASS', '/etc/raspcontrol/database.aptmnt');
define('FILE_PASS', 'database.aptmnt');

global $eth0;
$eth0 = 'wlan0';
$eth0 = 'eth0';
    
if ($rewriting) {
    define('LOGOUT', './logout');
    define('DETAILS', './details');
    define('SERVICES', './services');
    define('DISKS', './disks');
    define('HOMETEMP', './hometemp');
    define('CAM', './xiaomicam');
    define('TORRENTS', './torrents');
    define('DOWNLOADS', './downloads');
} else {
    define('LOGOUT', './login.php?logout');
    define('DETAILS', './?page=details');
    define('SERVICES', './?page=services');
    define('DISKS', './?page=disks');
    define('HOMETEMP', './?page=hometemp');
    define('CAM', './?page=xiaomicam');
    define('TORRENTS', './?page=torrents');
    define('DOWNLOADS', './?page=downloads');
}
?>
