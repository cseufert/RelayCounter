<?php

class modelCheckpoint {
  const TABLE = 'checkpoint';
  
  const T_ENTRY = 1;
  const T_EXIT = 2;
  
  static function openRow(&$o, $row) {
    $o->id = $row['id'];
    $o->name = $row['name'];
    $o->readerid = $row['readerid'];
    $o->type = $row['type'];
  }
}

?>
