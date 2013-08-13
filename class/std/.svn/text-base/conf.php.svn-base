<?php
/**
 * Standardised configuration loader
 *
 * @author Christopher Seufert <seufert@gmail.com>
 * @revision $Revision $
 * @package std
 */

class stdConf {

  /**
   * Configuration loaded from disk
   */
  static protected $config;

  /**
   * Return value based on key
   * @param string $key Key in format pkg.class.name
   * @param bool $err Throw Error Exception on key missing
   * @return mixed
   */
  static function getValue($key, $err = false) {
    if(!preg_match('/^([a-z0-9]+)\.([a-z0-9]+)\.(.+)$/',$key,$m))
      throw new Exception("Invalid Configuration Key ($key)");
    $pkg = $m[1];
    $class = $m[2];
    $type = $m[3];
    if(!isset(self::$config[$pkg][$class]))
      self::readFile($pkg,$class);
    if(!isset(self::$config[$pkg][$class][$type]))
      if($err) {
        throw new Exception("Missing Configuration Prameter ($key)");
      } else {
        return NULL;
      }
    return self::$config[$pkg][$class][$type];
  }

  static function setValue($key, $value, $err = false) {
    if(!preg_match('/^([a-z0-9]+)\.([a-z0-9]+)\.(.+)$/',$key,$m))
      throw new Exception("Invalid Configuration Key ($key)");
    $pkg = $m[1];
    $class = $m[2];
    $type = $m[3];
    $file = "conf/$pkg/$class.json";
    var_dump($file);
    if(!isset(self::$config[$pkg][$class]))
      self::readFile($pkg, $class);
    if(file_exists($file)) {
      self::$config[$pkg][$class][$type] = $value;
      file_put_contents($file, json_encode(self::$config[$pkg][$class]));
      return true;
    }
    throw new Exception("Could not open config file.");
  }
  
  static protected function readFile($pkg,$class) {
    self::$config[$pkg][$class] = array();
    $file = "conf/$pkg/$class.json";
    if(file_exists($file)) {
      $conf = file_get_contents($file);
      if(!strlen($conf)) return;
      self::$config[$pkg][$class] = json_decode($conf,true);
    }
  }
}
?>
