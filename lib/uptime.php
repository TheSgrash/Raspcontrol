<?php

namespace lib;

class Uptime {

    private static $MaxTemp = 30;
    
    public static function uptime() {
        global $ssh;
        $uptime = $ssh->shell_exec_noauth("cat /proc/uptime");
        $uptime = explode(" ", $uptime);

        return self::readbleTime($uptime[0]);
    }
    
    public static function heat() {
		global $ssh;
        $result = array();

        $currenttemp = $ssh->shell_exec_noauth('mytemp');
        if($currenttemp==""){
			$fh = fopen("/sys/bus/w1/devices/28-00000868d718/w1_slave", 'r');
			$tempo = fgets($fh);
			$tempo = fgets($fh);
			$currenttemp = substr($tempo,strpos($tempo,'t=')+2);
			fclose($fh);
		}
		
        $result['degrees'] = round($currenttemp / 1000);
        $result['percentage'] = round($result['degrees'] / self::$MaxTemp * 100);
		
        if ($result['degrees'] >= '30' OR $result['degrees'] <= '0')
            $result['alert'] = 'danger';
        elseif ($result['degrees'] <= '10')
            $result['alert'] = 'warning';
        else
            $result['alert'] = 'success';

        $result['detail'] = $cpuDetails;

        return $result;
	}

    protected static function readbleTime($seconds) {
        $y = floor($seconds / 60 / 60 / 24 / 365);
        $d = floor($seconds / 60 / 60 / 24) % 365;
        $h = floor(($seconds / 3600) % 24);
        $m = floor(($seconds / 60) % 60);
        $s = $seconds % 60;

        $string = '';

        if ($y > 0) {
            $yw = $y > 1 ? ' anni ' : ' anno ';
            $string .= $y . $yw;
        }

        if ($d > 0) {
            $dw = $d > 1 ? ' giorni ' : ' giorno ';
            $string .= $d . $dw;
        }

        if ($h > 0) {
            $hw = $h > 1 ? ' ore ' : ' ora ';
            $string .= $h . $hw;
        }

        if ($m > 0) {
            $mw = $m > 1 ? ' minuti ' : ' minuto ';
            $string .= $m . $mw;
        }

        if ($s > 0) {
            $sw = $s > 1 ? ' secondi ' : ' secondo ';
            $string .= $s . $sw;
        }

        return preg_replace('/\s+/', ' ', $string);
    }

}

?>
