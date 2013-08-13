<?php

class stdDateConvert {
  private $start;
  private $end;
  
  function __construct($start, $end) {
    $this->start = $start;
    $this->end = $end;
  }
  
  function toNiceAge() {
    $units = array
    (
     "day"          => 86400,    // seconds in a day    (24 hours)
     "hour"         => 3600,     // seconds in an hour  (60 minutes)
     "minute"       => 60,       // seconds in a minute (60 seconds)
     "second"       => 1,        // 1 second
     "ms"           => 0.0001    // 1000 milliseconds in 1 second
    );

    $diff = abs($this->end - $this->start);
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
  
  function toCountdownClock() {
    //$start = new DateTime((int)$this->start);
    //$end = new DateTime((int)$this->end);
    //var_dump((int)$this->start, (int)$this->end);
    //$interval = $start->diff($end);
    //return $interval->format("%H:%I:%S");
    $diff = abs($this->end - $this->start);
    //$years = floor($diff / (365*60*60*24));
    //$months = floor(($diff - $years *365*60*60*24) / (30*60*60*24));
    //$days = floor(($diff - $years *365*60*60*24 - $months *30*60*60*24) / (60*60*24));
    //$hours = floor(($diff - $years *365*60*60*24 - $months *30*60*60*24 - $days * 60*60*24) / (60*24));
    //$minutes = floor(($diff - $years *365*60*60*24 - $months *30*60*60*24 - $days * 60*60*24 - $hours * 60*24));
    $minutes = floor($diff / 60 % 60);
    $hours = floor($diff / 60 / 60);
    $seconds = floor($diff % 60);
    return $hours . ":" . $minutes . ":" . $seconds;
  }
}

?>
