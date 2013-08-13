<?php 

/**
 * View Base Class for the CM framework
 * 
 * @author Michael Bates
 * @package framework 
 */
abstract class frameworkView {
  
  protected $t;
  
  protected $model;
  
  protected $requiresid = false;
  
  protected $extraparams;
  
  static function load($id = false, $tpl = false, array $extraparams = array()) {
    $t = get_called_class();
    $o = new $t();
    if($tpl)
      $o->t = stdTpl::open(get_class($o), strtolower($tpl));
    else
      $o->t = stdTpl::open(get_class($o), 'view');
    if($o->requiresid === true && $id === false)
      throw new frameworkView_Exception_RequiresID("ID Must be set in Query String.");
    $class_name = $o->getClass(get_class($o));
    $class = 'model' . $class_name;
    if($id) {
      if(!class_exists($class))
        throw new frameworkView_Exception_InvalidModel("Model could not be found.");
      $o->model = $class::single($id);
    }
    else
      $o->model = false;
    if($extraparams) {
      $o->extraparams = $extraparams;
    }
    $o->check();
    return $o;
  }
  
  private function getClass($class) {
    if(preg_match("/^([a-z]+)([A-Z][a-z]+)/", $class, $m)) {
      return $m[2];
    }
    return false;
  }  
  
  function check() {
    return true;
  }
  
  abstract function loadTemplate();
  
  function toString() {
    return $this->t->toString();
  }
  
  function __toString() {
    return $this->toString();
  }
  
  function setAttr($key, $val) {
    $this->t->setAttr(array($key=>$val));
  }
  
  function setFlag($key, $condition) {
    $this->t->setFlag($key, $condition);
  }
}

class frameworkView_Exception_InvalidModel extends Exception {
  
}

class frameworkView_Exception_RequiresID extends Exception {
  
}

?>
