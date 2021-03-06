<?php

class modelTeam extends frameworkModel {
  const TABLE = 'team';
  
  static function openRow(&$o, $row) {
    $o->id = $row['id'];
    $o->name = $row['name'];
    try {
        $o->leader = modelRunner::single($row['leaderid']);
    } catch (frameworkModel_Exception_ZeroResults $ex) {
        $o->leader = false;
    }
    $o->distance = $row['distance'];
    $o->avglap = $row['avglap'];
    $o->bestlap = $row['bestlap'];
    $o->worstlap = $row['worstlap'];
    $o->lastlap = $row['lastlap'];
    $o->totallaps = $row['totallaps'];
    $o->avgindex = $row['avgindex'];
    $o->form = $row['form'];
    $o->consistent = $row['consistent'];
    $o->teamplay = $row['teamplay'];
  }
}

?>
