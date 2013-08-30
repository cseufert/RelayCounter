<?php

class modelRunner extends frameworkModel {
  const TABLE = "runner";
  
  static function openRow(&$o, $row) {
    $o->id = $row['id'];
    $o->chipcode = $row['chipcode'];
    $o->first = $row['first'];
    $o->last = $row['last'];
    $o->bibno = $row['bibno'];
    $o->team = modelTeam::single($row['teamid']);
    $o->form = $row['form'];
    $o->percentage = $row['percentage'];
    $o->lastcheckpoint = modelCheckpoint::single($row['lastcheckpointid']);
    $o->lastcheckpointtime = stdDate($row['lastcheckpointtime']);
  }
  
  function onLeadLap() {
      $lastcheckpoint = $this->team->leader->lastcheckpoint;
      $lastcheckpointtime = $this->team->leader->lastcheckpointtime;
      if($lastcheckpoint->id != $this->lastcheckpoint->id)
          return false; // member is not running in same stage
      if($lastcheckpointtime > $this->lastcheckpointtime)
          return false; // member left last checkpoint before leader
      return true;
  }
  
  function isLeader() {
      return $this->id == $this->team->leader->id;
  }
}

?>
