<?php

namespace lib;

class Network {

    public static function connections() {
        global $ssh;
        $connections = $ssh->shell_exec_noauth("netstat -nta --inet | wc -l");
        $connections--;

        return array(
            'connections' => substr($connections, 0, -1),
            'alert' => ($connections >= 50 ? 'warning' : 'success')
        );
    }

    public static function ethernet() {
        global $ssh,$eth0;
        $data = $ssh->shell_exec_noauth("ip -s link show $eth0 | tail -n+4 | cut -d \" \" -f5 | sed -e '/^TX.*$/d'");
        $data = trim($data);
        $data = explode("\n", $data);
        
		$rxRaw = $data[0] / 1024 / 1024;
        $txRaw = $data[1] / 1024 / 1024;
        
        $rx = round($rxRaw, 2);
        $tx = round($txRaw, 2);

        return array(
            'up' => $tx,
            'down' => $rx,
            'total' => $rx + $tx
        );
    }

}
