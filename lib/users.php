<?php

namespace lib;

class Users {
  
  public static function connected() {

    $result = array();

    /* Not Used
    $dataRaw = shell_exec("who --ips");
    */
    $dataRawDNS = shell_exec("who --lookup");

    foreach (explode ("\n", $dataRawDNS) as $line) {
      $line = preg_replace("/ +/", " ", $line);

      if (strlen($line)>0) {
        $line = explode(" ", $line);
        $temp[] = $line[5];
      }
    }

    $i = 0;
    /* before
    foreach (explode ("\n", $dataRaw) as $line) {
    */
    /* after */
    foreach (explode ("\n", $dataRawDNS) as $line) {
      $line = preg_replace("/ +/", " ", $line);

      if (strlen($line)>0) {
        $line = explode(" ", $line);

        $result[] = array(
          'user' => $line[0],
          'ip' => $line[5],
          'dns' => $temp[$i],
          'date' => $line[2] .' '. $line[3],
          'hour' => $line[4]
          );
      }
      $i++;
    }

    return $result;
  }

}

?>
