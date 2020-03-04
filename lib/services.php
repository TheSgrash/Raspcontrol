<?php

namespace lib;

class Services {

    public static function services() {
        global $ssh;

        $result = array();
        $scartati = array();
		
        $servicesArray = $ssh->exec_noauth("systemctl --all | tail -n+2 | head -n-7 | sed -e 's/●//g' | sed -e 's/  */ /g' | cut -d \" \" -f2,4 | perl -p -e 's/^(.*) active$/[ + ]  $1/g' | perl -p -e 's/^(.*) inactive$/[ - ]  $1/g' | perl -p -e 's/^(.*) failed$/[ ? ]  $1/g'");
        
        if($servicesArray[0][0]!="["){
			$servicesArray = $ssh->exec_noauth("systemctl --all | tail -n+2 | head -n-7 | sed -e 's/●//g' | sed -e 's/  */ /g' | cut -d \" \" -f1,3 | perl -p -e 's/^(.*) active$/[ + ]  $1/g' | perl -p -e 's/^(.*) inactive$/[ - ]  $1/g' | perl -p -e 's/^(.*) failed$/[ ? ]  $1/g'");
		}
        
        $result[0]['tot'] = count($servicesArray);
        
		$j=1;
		$k=0;
        for ($i = 0; $i < $result[0]['tot']; $i++) {
			for($x=4;$x<15;$x++){
				$str["$x"] = substr($servicesArray[$i],7,$x);
			}
			$str["-6"] = substr($servicesArray[$i],-6,6);
			$str["-7"] = substr($servicesArray[$i],-7,7);
			if($str["4"] != "dev-" AND $str["4"] != "sys-" AND $str["5"] != "proc-" AND $str["5"] != "user@" AND $str["6"] != "getty@" AND $str["7"] != "serial-" AND $str["7"] != "netctl-" AND $str["7"] != "rescue." AND $str["8"] != "systemd-" AND $str["9"] != "plymouth-" AND $str["11"] != "mkinitcpio-" AND $str["11"] != "sys-devices" AND $str["-6"] != ".mount" AND $str["-6"] != ".slice" AND $str["-6"] != ".scope" AND $str["-6"] != ".timer" AND $str["-6"] != ".timer" AND $str["-7"] != ".target" AND $str["-7"] != ".socket"){
				$servicesArray[$i] = preg_replace('!\s+!', ' ', $servicesArray[$i]);
				preg_match_all('/\S+/', $servicesArray[$i], $serviceDetails);
				list($bracket1, $status, $bracket2, $name) = $serviceDetails[0];
				$result[$j]['name'] = $name;
				$result[$j]['status'] = $status;
				$j++;
			} else {
				$servicesArray[$i] = preg_replace('!\s+!', ' ', $servicesArray[$i]);
				preg_match_all('/\S+/', $servicesArray[$i], $serviceDetails);
				list($bracket1, $status, $bracket2, $name) = $serviceDetails[0];
				$scartati[$k]['name'] = $name;
				$scartati[$k]['status'] = $status;
				$k++;
			}
        }
		$result[0]['scart'] = $k;
		return array_merge($result,$scartati);
    }

    public static function servicesRunning() {
        $services = self::services();

        $result = array();

        for ($i = 0; $i < count($services); $i++) {
            if ($services[$i]['status'] == '+') {
                array_push($result, $services[$i]);
            }
        }

        return $result;
    }
    
    public static function getService($name) {
        global $ssh;

        $result = array();
		
        $service = $ssh->exec_noauth("systemctl status $name | head -n+3 | tail -n-2| perl -p -e 's/^.*: (.*) \(.*$/$1/g'");
        if($service[0]=="loaded") return $service[1];
        else return $service[0];
    }

}

?>
