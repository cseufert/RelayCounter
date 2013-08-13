<?php

class viewHome extends frameworkView {
  static function secsToNice($s) {
    $s = round($s);
    $m = 0;
    while($s > 60) {
      $m++; $s = $s - 60;
    }
    return $m.":".sprintf("%02d",$s);
  }
  function loadTemplate() {
    $teams = modelTeam::all("distance DESC");
    $totalkms = 0;
    foreach($teams as $team) {
      $totalkms += $team->distance;
    }
    $start = stdConf::getValue("std.race.start", true);
    $end = $start + (24 * 60 * 60);
    $now = microtime(true);
    $convert = new stdDateConvert($end, $now);
    $this->t->setAttr(array("DISTANCE"=> $totalkms / 1000,
                            "FIRST"=>$teams[0]->name,
                            "SECOND"=>$teams[1]->name,
                            "THIRD"=>$teams[2]->name,
                            "CLOCK"=>$convert->toCountdownClock()));
    $pos = 1;
    if($tAll = $this->t->getSubTpl("ALL")) {
      foreach($teams as $i=>$team) {
        $tAll->setAttr(array("NAME"=>$team->name,
                             "DISTANCE"=>$team->distance / 1000,
                             "AVERAGELAP"=>$this->secsToNice($team->avglap),
                             "BESTLAP"=>$this->secsToNice($team->bestlap),
                             "LASTLAP"=>$this->secsToNice($team->lastlap),
                             "TOTALLAPS"=>$team->totallaps,
                             "POS"=>$pos,
                             "ID"=>$team->id));
        $tAll->next();
        $pos++;
      }
    }
    $pos = 1;
    if($tTop = $this->t->getSubTpl("TOP")) {
      $ix = 0;
      foreach($teams as $i=>$team) {
        if($ix >= 16) break;
        $tTop->setAttr(array("NAME"=>$team->name,
                             "DISTANCE"=>$team->distance / 1000,
                             "AVERAGELAP"=>$this->secsToNice($team->avglap),
                             "BESTLAP"=>$this->secsToNice($team->bestlap),
                             "LASTLAP"=>$this->secsToNice($team->lastlap),
                             "TOTALLAPS"=>$team->totallaps,
                             "POS"=>$pos,
                             "ID"=>$team->id));
        unset($teams[$i]);
        $tTop->next();
        $ix++;
        $pos++;
      }
    }
    if($tRestOne = $this->t->getSubTpl("RESTONE")) {
      $ix = 0;
      foreach($teams as $i=>$team) {
        if($ix >= 26) break;
        $tRestOne->setAttr(array("NAME"=>$team->name,
                             "DISTANCE"=>$team->distance / 1000,
                             "AVERAGELAP"=>$this->secsToNice($team->avglap),
                             "BESTLAP"=>$this->secsToNice($team->bestlap),
                             "LASTLAP"=>$this->secsToNice($team->lastlap),
                             "TOTALLAPS"=>$team->totallaps,
                             "POS"=>$pos,
                             "ID"=>$team->id));
        unset($teams[$i]);
        $tRestOne->next();
        $ix++;
        $pos++;
      }
    }
    if($tRestTwo = $this->t->getSubTpl("RESTTWO")) {
      $ix = 0;
      foreach($teams as $i=>$team) {
        if($ix >= 26) break;
        $tRestTwo->setAttr(array("NAME"=>$team->name,
                             "DISTANCE"=>$team->distance / 1000,
                             "AVERAGELAP"=>$this->secsToNice($team->avglap),
                             "BESTLAP"=>$this->secsToNice($team->bestlap),
                             "LASTLAP"=>$this->secsToNice($team->lastlap),
                             "TOTALLAPS"=>$team->totallaps,
                             "POS"=>$pos,
                             "ID"=>$team->id));
        unset($teams[$i]);
        $tRestTwo->next();
        $ix++;
        $pos++;
      }
    }
    if($tRestThree = $this->t->getSubTpl("RESTTHREE")) {
      $ix = 0;
      foreach($teams as $i=>$team) {
        if($ix >= 26) break;
        $tRestThree->setAttr(array("NAME"=>$team->name,
                             "DISTANCE"=>$team->distance / 1000,
                             "AVERAGELAP"=>$this->secsToNice($team->avglap),
                             "BESTLAP"=>$this->secsToNice($team->bestlap),
                             "LASTLAP"=>$this->secsToNice($team->lastlap),
                             "TOTALLAPS"=>$team->totallaps,
                             "POS"=>$pos,
                             "ID"=>$team->id));
        unset($teams[$i]);
        $tRestThree->next();
        $ix++;
        $pos++;
      }
    }
    if($tRestFour = $this->t->getSubTpl("RESTFOUR")) {
      $ix = 0;
      foreach($teams as $i=>$team) {
        if($ix >= 26) break;
        $tRestFour->setAttr(array("NAME"=>$team->name,
                             "DISTANCE"=>$team->distance / 1000,
                             "AVERAGELAP"=>$this->secsToNice($team->avglap),
                             "BESTLAP"=>$this->secsToNice($team->bestlap),
                             "LASTLAP"=>$this->secsToNice($team->lastlap),
                             "TOTALLAPS"=>$team->totallaps,
                             "POS"=>$pos,
                             "ID"=>$team->id));
        unset($teams[$i]);
        $tRestFour->next();
        $ix++;
        $pos++;
      }
    }
    try {
      $s1_val = stdConf::getValue("std.stats.fastest-1st");
      $s1_team = modelTeam::single(stdConf::getValue("std.stats.fastest-1st-team"))->name;
    } catch(Exception $e) {
      $s1_val = "";
      $s1_team = "Not Calculated";
    }
    try {
      $s2_val = stdConf::getValue("std.stats.form-1st");
      $s2_team = modelTeam::single(stdConf::getValue("std.stats.form-1st-team"))->name;
    } catch(Exception $e) {
      $s2_val = "";
      $s2_team = "Not Calculated";
    }
    try {
      $s3_val = stdConf::getValue("std.stats.consistent-1st");
      $s3_team = modelTeam::single(stdConf::getValue("std.stats.consistent-1st-team"))->name;
    } catch(Exception $e) {
      $s3_val = "";
      $s3_team = "Not Calculated";
    }
    try {
      $s4_val = stdConf::getValue("std.stats.teamplay-1st");
      $s4_team = modelTeam::single(stdConf::getValue("std.stats.teamplay-1st-team"))->name;
    } catch(Exception $e) {
      $s4_val = "";
      $s4_team = "Not Calculated";
    }
    $this->t->setAttr(array("S1NAME"=>$s1_team, "S1TIME"=>$s1_val,
                        "S2NAME"=>$s2_team, "S2TIME"=>$s2_val,
                        "S3NAME"=>$s3_team, "S3TIME"=>$this->secsToNice($s3_val),
                        "S4NAME"=>$s4_team, "S4TIME"=>round($s4_val)));
  }
}

?>
