<?php

class modelCheckpoint {
  const TABLE = 'checkpoint';
  
  static function openRow(&$o, $row) {
    $o->id = $row['id'];
    $o->name = $row['name'];
  }
}

?>
