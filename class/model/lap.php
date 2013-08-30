<?php

class modelLap extends frameworkModel {
  const TABLE = 'lap';
  
  const S_CONFIRMED = 0;
  const S_UNCONFIRMED = 1;
  
  static function openRow(&$o, $row) {
    $o->runnerid = $row['runnerid'];
    $o->timecode = new stdDate($row['timecode']);
    $o->checkpointid = $row['checkpointid'];
  }
}

?>
