<?php 

/**
 * Database Overload utility class for the CM framework
 * 
 * @author Michael Bates <michael@goquinella.com>
 * @package framework 
 */

abstract class frameworkDBOverload {
  
  protected $properties = array();
  
  function __get($name) {
    if(isset($this->properties[$name])) {
      return $this->properties[$name];
    }
    return null;
  }
  
  function __set($name, $value) {
    if(!isset($this->properties[$name])) {
      $this->properties[$name] = $value;
      return true;
    }
    if($value instanceof inFile) {
      $name .= "id";
      $value = $value->getModel()->id;
    }
    $q = "UPDATE ".static::TABLE." SET $name = '".stdDB::escape($value)."' WHERE id = ".$this->id;
    if(stdDB::query($q)) {
      $this->properties[$name] = $value;
      return true;
    }
    return false;
  }
  
  function __isset($name) {
    return isset($this->properties[$name]);
  }
}

?>
