<?php

class apiLap extends frameworkApi {
  function doCreate($p) {
    if(!$this->requires($p, array("data"), $error, $errorcount)) {
      $this->error = $error;
      $this->state = frameworkApi::STATE_ERROR;
      return print_r($p, true);
    }
    $regex = "/([0-9]+)\t([0-9]{4}\-[0-9]{2}\-[0-9]{2}) ([0-9]{2}\:[0-9]{2}\:[0-9]{2}\.[0-9]{3})/";
    if(preg_match($regex, trim($p['data']), $m)) {
      $datestr = $m[2] . "T" . $m[3];
      $time = strtotime($datestr);
      $start = stdConf::getValue("std.race.start");
      $diff = abs($time - $start);
      $runner = modelRunner::where(array("chipcode"=>$m[1]));
      /*$q = "SELECT * FROM lap WHERE teamid = " . $runner[0]->teamid . " ORDER BY -id";
      $row = stdDB::selectOne($q);
      if($row)
        $thislap = abs($row['timecode'] - $diff);
      else
        $thislap = $diff;*/
      $t = stdDB::selectOne("SELECT MAX(timecode) as t FROM lap WHERE teamid = ".$runner[0]->teamid);
      $thislap = $diff - $t['t'];
      $q = stdDB::query("SELECT * FROM lap WHERE timecode+42 > $diff and teamid = ".$runner[0]->teamid);
      
      if(!mysql_num_rows($q)) {
        //var_dump("Here we are");
        $lap = modelLap::insert(array('runnerid'=>$runner[0]->id, 'timecode'=>$diff, 'teamid'=>$runner[0]->teamid));
        $team = modelTeam::single($runner[0]->teamid);
        //$team->distance = $team->distance  + (1 * D_OVAL);
        $t_laps = stdDB::selectOne("SELECT count(id) as t FROM lap WHERE teamid = ".$runner[0]->teamid);
        if($t_laps)
          $team->totallaps = $t_laps['t'];
        else
          $team->totallaps = 0;
        //if($team->avgindex == 0) {
          //$team->avgindex = $thislap;
          //$team->avglap = $thislap;
        //} else {
          $t_time = stdDB::selectOne("SELECT max(timecode) as max FROM lap WHERE teamid   = ".$runner[0]->teamid);
          //$team->avgindex = $team->avgindex + $thislap;
          //$team->avglap = $team->avglap == 0 ? $thislap : $team->avglap;
        //}
        if($t_time)
          $team->avglap = $t_time['max'] / $team->totallaps;
        else
          $team->avglap = 0;
        $laps = stdDB::query("SELECT timecode FROM lap WHERE teamid = ".$runner[0]->teamid." ORDER BY timecode ASC");
        $last = 0;
        $best = 0;
        $worst = 0;
        while($row = mysql_fetch_assoc($laps)) {
          $time = $row['timecode'] - $last;
          if($time < 45) continue;
          $best = ($best == 0)?$time:($best > $time?$time:$best);
          $worst = ($worst == 0)?$time:($worst < $time?$time:$worst);
          $last = $row['timecode'];
        }
        /*$team->bestlap = $team->bestlap == 0 ? $thislap : $team->bestlap;
        $team->bestlap = $thislap < $team->bestlap ? $thislap : $team->bestlap;
        $team->worstlap = $team->worstlap == 0 ? $thislap : $team->worstlap;
        $team->worstlap = $thislap > $team->worstlap ? $thislap : $team->worstlap;*/
        $team->bestlap = $best;
        $team->worstlap = $last;
        $team->lastlap = $thislap;
        $team->distance = $team->totallaps * D_OVAL;
        
        //Calculate stats
        
        $q = "SELECT * FROM team WHERE bestlap <> 0 ORDER BY bestlap ASC";
        $r = stdDB::query($q);
        $row1 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.fastest-1st", $row1['bestlap']);
        stdConf::setValue("std.stats.fastest-1st-team", $row1['id']);
        $row2 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.fastest-2nd", $row2['bestlap']);
        stdConf::setValue("std.stats.fastest-2nd-team", $row2['id']);
        $row3 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.fastest-3rd", $row3['bestlap']);
        stdConf::setValue("std.stats.fastest-3rd-team", $row3['id']);
        unset($row1, $row2, $row3);
        
        $lhh = $diff - 1800;
        $q = "SELECT count(id) as t FROM lap WHERE teamid = " . $team->id . " AND timecode > $lhh";
        $r = stdDB::selectOne($q);
        $count = $r['t'];
        
        $team->form = $count;
        $q = "SELECT * FROM team WHERE form <> 0 ORDER BY form DESC";
        $r = stdDB::query($q);
        $row1 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.form-1st", $row1['form']);
        stdConf::setValue("std.stats.form-1st-team", $row1['id']);
        $row2 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.form-2nd", $row2['form']);
        stdConf::setValue("std.stats.form-2nd-team", $row2['id']);
        $row3 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.form-3rd", $row3['form']);
        stdConf::setValue("std.stats.form-3rd-team", $row3['id']);
        unset($row1, $row2, $row3);
        
        $consist_index = $team->worstlap - $team->bestlap;
        $team->consistent = $consist_index;
        $q = "SELECT * FROM team WHERE consistent <> 0 ORDER BY consistent ASC";
        $r = stdDB::query($q);
        $row1 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.consistent-1st", $row1['consistent']);
        stdConf::setValue("std.stats.consistent-1st-team", $row1['id']);
        $row2 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.consistent-2nd", $row2['consistent']);
        stdConf::setValue("std.stats.consistent-2nd-team", $row2['id']);
        $row3 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.consistent-3rd", $row3['consistent']);
        stdConf::setValue("std.stats.consistent-3rd-team", $row3['id']);
        unset($row1, $row2, $row3);
        
        $q = "SELECT count(id) as t, runnerid FROM lap WHERE teamid = " . $team->id." GROUP BY runnerid";
        $spread = array();
        $r = stdDB::query($q);
        $last = 0;
        while($row = mysql_fetch_assoc($r)) {
          $spread[] = $row['t'];// - $last;
          //$last = $row['timecode'];
        }
        $sd = stats_standard_deviation($spread);
        $team->teamplay = $sd;
        $q = "SELECT * FROM team WHERE teamplay <> 0 ORDER BY teamplay ASC";
        $r = stdDB::query($q);
        $row1 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.teamplay-1st", $row1['teamplay']);
        stdConf::setValue("std.stats.teamplay-1st-team", $row1['id']);
        $row2 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.teamplay-2nd", $row2['teamplay']);
        stdConf::setValue("std.stats.teamplay-2nd-team", $row2['id']);
        $row3 = mysql_fetch_assoc($r);
        stdConf::setValue("std.stats.teamplay-3rd", $row3['teamplay']);
        stdConf::setValue("std.stats.teamplay-3rd-team", $row3['id']);
        unset($row1, $row2, $row3);
        return true;
      }
    }
    return false;
  }
}

?>
