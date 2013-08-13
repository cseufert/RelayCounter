<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Standardised Date Class
 * Use to handle date between formats
 *
 * @author Christoper Seufert <seufert@gmail.com>
 * @author Michael Bates <michael.kiomega@gmail.com>
 * @package std
 * @version $Rev $
 */
class stdDate {
  
  protected $ts;

  function __construct($date = false) {
    if(!$date)
      $this->ts = time();
    else
      $this->ts = strtotime($date);
  }

  function __toString() {
    return date("Y-m-d H:i:s", $this->ts);
  }

  function toSQLDate() {
    return date("Y-m-d H:i:s", $this->ts);
  }

  function toNiceDate() {
    return date("j F Y", $this->ts);
  }

  function toTS() {
    return $this->ts;
  }

  function toNiceAge($to = null) {
    $to = (($to === null) ? (time()) : ($to));
    $to = ((is_int($to)) ? ($to) : (strtotime($to)));

    $units = array
    (
     "day"    => 86400,    // seconds in a day    (24 hours)
     "hour"   => 3600,     // seconds in an hour  (60 minutes)
     "minute" => 60,       // seconds in a minute (60 seconds)
     "second" => 1         // 1 second
    );

    $diff = abs($this->ts - $to);
    if($diff < 60) return " <1 minute";
    $suffix = (($this->ts > $to) ? ("from now") : (""));
    $output = "";
    foreach($units as $unit => $mult)
     if($diff >= $mult)
     {
      //$and = (($mult != 1) ? ("") : ("and "));
      $output .= ", ".intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
      $diff -= intval($diff / $mult) * $mult;
      break;
     }
    $output .= " ".$suffix;
    $output = substr($output, strlen(", "));

    return $output;
  }
  function toNiceAgeArray($to = null) {
    $to = (($to === null) ? (time()) : ($to));
    $to = ((is_int($to)) ? ($to) : (strtotime($to)));

    $units = array
    (
     "day"    => 86400,    // seconds in a day    (24 hours)
     "hour"   => 3600,     // seconds in an hour  (60 minutes)
     "minute" => 60,       // seconds in a minute (60 seconds)
     "second" => 1         // 1 second
    );

    $diff = abs($this->ts - $to);
    if($diff < 60) return array("new"=>"!");
    //$suffix = (($this->ts > $to) ? ("from now") : (""));
    $output = array();
    foreach($units as $unit => $mult)
     if($diff >= $mult)
     {
      //$and = (($mult != 1) ? ("") : ("and "));
      $output[$unit.((intval($diff / $mult) == 1) ? ("") : ("s"))] = intval($diff / $mult);
      $diff -= intval($diff / $mult) * $mult;
      break;
     }

    return $output;
  }
  
  function addSecond($secs) {
    $this->ts += $secs;
  }
  
  function toFormat($f) {
    return date($f,$this->ts);
  }

  function addSecondsSkipWeekend($secs, $skipWeekend = false) {
      while($secs > 0) {
      if($secs > 24*3600) {
        $this->ts += 24*3600;
        $secs -= 24*3600;
      } else {
        $this->ts += $secs;
        $secs -= $secs;
      }
      if($skipWeekend) {
        if($this->toFormat("w") == 6)
                $this->ts += 2*24*3600;
      }
    }
  }

}
?>