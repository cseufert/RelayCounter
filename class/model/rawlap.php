<?php

class modelRawLap extends frameworkModel {
  const TABLE = 'rawlap';
  
  static function openRow(&$o, $row) {
    $o->id = $row['id'];
    $o->time = $row['time'];
    $o->chipcode = $row['chipcode'];
    $o->readerid = $row['readerid'];
  }
}
