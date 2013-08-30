<?php

class modelLap extends frameworkModel {
  const TABLE = 'lap';
  
  static function openRow(&$o, $row) {
    $o->runnerid = $row['runnerid'];
    $o->timecode = new stdDate($row['timecode']);
    $o->checkpointid = $row['checkpointid'];
  }
}

?>
