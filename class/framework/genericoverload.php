<?php 

/**
 * Generic Overload utility class for the CM framework
 * 
 * @author Michael Bates <michael@goquinella.com>
 * @package framework 
 */
class frameworkGenericOverload {
  
  protected $properties = array();
  
  function __get($name) {
    if(isset($this->properties[$name])) {
      return $this->properties[$name];
    }
    return null;
  }
  
  function __set($name, $value) {
    $this->properties[$name] = $value;
  }
  
  function __isset($name) {
    return isset($this->properties[$name]);
  }
  
}

?>
