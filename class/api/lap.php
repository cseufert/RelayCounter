<?php

class apiLap extends frameworkApi {
  
  function doCreate($p) {
     if(!$this->requires($p, array("time", "chipcode", "readerid"), $error, $errorcount)) {
      $this->error = $error;
      $this->state = frameworkApi::STATE_ERROR;
      return print_r($p, true);
    } 
    $rawlap = modelRawLap::insert(array("time"=>trim($p['time']), "chipcode"=>trim($p['chipcode']), "readerid"=>trim($p['readerid'])));
    $this->onNewTag($rawlap);
  }
  
  function onNewTag($rawlap) {
      $runner = modelRunner::where(array("chipcode"=>$rawlap->chipcode));
      $time = stdConf::get("std.race.start") - $rawlap->time;
      $checkpoint = modelCheckpoint::where(array("readerid"=>$rawlap->readerid));
      if($runner->lastcheckpoint->id == $checkpoint->id && $runner->lastcheckpointtime->toTS() > microtime() - (10000000)) {
          return; // duplicate read
      }
      return $this->onNewRead($runner, $time, $checkpoint);
  }
  
  function onNewRead($runner, $time, $checkpoint) {
      modelCheckpoint::insert(array("runnerid"=>$runner->id, "time"=>$time, "checkpointid"=>$checkpoint->id));
      if(!$runner->onLeadLap())
          return; // Not competitor read
      if($checkpoint->isEntry()) {
          try {
              $lap = modelLap::where(array("runnerid"=>$runner->id, "time"=>$time, "checkpointid"=>$checkpoint->id));
              if($runner->isLeader()) {
                  $lap = modelLap::insert(array("runnerid"=>$runner->id, "time"=>$time, "checkpoint"=>$checkpoint->id, ))
              }
          } catch (frameworkModel_Exception_ZeroResults $ex) {
              if($runner->isLeader()) {
                  
              }
          }
      }
  }
}

?>
