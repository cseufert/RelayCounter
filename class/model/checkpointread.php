<?php

class modelCheckpoint {
  const TABLE = 'checkpointread';
  
  static function openRow(&$o, $row) {
      $o->id = $row['id'];
      $o->runner = modelRunner::insert($row['runnerid']);
      $o->time = $row['time'];
      $o->checkpoint = modelCheckpoint::single($row['checkpointid']);
  }
}

?>
