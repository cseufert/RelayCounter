<?php 

/**
 * Model Base Class for the CM Framework
 *
 * @author Michael Bates
 * @package framework
 */
abstract class frameworkModel extends frameworkDBOverload {
  
  const TABLE = null;
  const PARENT_TABLE = null;
  
  const W_STATUS = 'status';
  const W_UID    = 'uid';
  const W_PARENT = '__pid__';
  
  protected static $cache;
  
  protected static $count = false;

  static function insert($params = array(), $ignoreid = false) {
    $t = get_called_class();
    $params = array_merge($t::defaults(), $params);
    if($params) {
      if($ignoreid)
        return stdDB::insertArray(static::TABLE, $params);
      else
      return self::single(stdDB::insertArray(static::TABLE, $params));
    } else {
      $q = "INSERT INTO " . static::TABLE;
      $result = stdDB::insert($q);
      if($ignoreid)
        return $result;
      else
        return self::single($result);
    }
  }
  
  static function delete($params = array()) {
    $t = get_called_class();
    if(count($params) == 0)
      return false;
    return stdDB::deleteArray(static::TABLE, $params);
  }
  
  static function defaults() {
    return array();
  }
  
  static function single($id) {
    $t = get_called_class();
    if(!isset($t::$cache[$t]))
      $t::$cache[$t] = array();
    if(isset($t::$cache[$t][$id]))
      return $t::$cache[$t][$id];
    $q = "SELECT * FROM " . static::TABLE . " WHERE id = $id  LIMIT 1";
    return self::openResult(stdDB::query($q));
  }
  
  static function all($order = false) {
    if($order) 
      $q = "SELECT * FROM " . static::TABLE . " ORDER BY $order";
    else
      $q = "SELECT * FROM " . static::TABLE;
    return self::openResultArray(stdDB::query($q));
  }
  
  static function where($key, $val = false, $sort = false, $count = false) {
    if(is_array($key)) {
      $q = "SELECT * FROM " . static::TABLE . " WHERE ";
      foreach($key as $k=>$v) {
        if($k == "__pid__")
          $k = static::PARENT_TABLE . 'id';
        $q .= "$k = '".stdDB::escape($v)."' AND ";
      }
      $q = substr($q, 0, -5);
      if($sort)
        $q .= " ORDER BY $sort";
    } else {
      if($key == "__pid__")
        $key = static::PARENT_TABLE . 'id';
      if($sort)
        $q = "SELECT * FROM " . static::TABLE . " WHERE $key = '".stdDB::escape($val)."' ORDER BY $sort";
      else
        $q = "SELECT * FROM " . static::TABLE . " WHERE $key = '".stdDB::escape($val)."'";
	  if($count)
	    self::$count = true;
    }
    return self::openResultArray(stdDB::query($q));
  }
  
  static function multiple(array $ids) {
    $q = "SELECT * FROM " . static::TABLE . " WHERE id IN (" .implode(", ", $ids). ")";
    return self::openResultArray(stdDB::query($q));
  }
  
  static function openResult($r) {
    $t = get_called_class();
    if(!mysql_num_rows($r))
      throw new frameworkModel_Exception_ZeroResults("Query did not return enough rows.");
    $row = mysql_fetch_assoc($r);
    $o = $t::openRowInternal($row);
    $t::$cache[$t][$o->id] = $o;
    return $o;
  }
  
  static function openResultArray($r) {
    $t = get_called_class();
    if(!mysql_num_rows($r))
      throw new frameworkModel_Exception_ZeroResults("Query did not return enough rows.");
    $out = array();
	$i = 1;
    while($row = mysql_fetch_assoc($r)) {
      $o = $t::openRowInternal($row);
	  if(self::$count)
	    $o->i = i;
      $t::$cache[$t][$o->id] = $o;
      $out[] = $o;
	  $i++;
    }
	self::$count = false;
    return $out;
  }
  
  private static function openRowInternal($row) {
    $t = get_called_class();
    $o = new $t();
    $t::openRow($o, $row);
    return $o;
  }
  
  static function openRow(&$o, $row) {
    return true;
  }
  
  function getParent() {
    if(static::PARENT_TABLE == null) 
      throw new frameworkModel_Exception_InvalidParent("Trying to get parent model on object without a parent.");
    $class = "model" . ucfirst(static::PARENT_TABLE);
    if(!class_exists($class))
      throw new frameworkModel_Exception_InvalidParent("Invalid parent model type.");
    $parentidprop = static::PARENT_TABLE . "id";
    $obj = $class::single($this->$parentidprop);
    return $obj;
  }
}

class frameworkModel_Exception_ZeroResults extends Exception {
  
}

class frameworkModel_Exception_InvalidParent extends Exception {
  
}

?>
