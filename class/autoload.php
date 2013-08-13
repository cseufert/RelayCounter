<?php
date_default_timezone_set('Australia/Melbourne');
error_reporting(E_ALL ^ E_STRICT | E_NOTICE);
function inAutoload($class) {
  if(preg_match("/^([a-z0-9]+)([A-Z][a-zA-Z0-9]*)(_[a-zA-Z_]+)?$/", $class, $m)) {
    $path = "class/".$m[1]."/".strtolower($m[2]).".php";
    if(file_exists($path))
      require_once($path);
  }
}
require_once('config.php');
spl_autoload_register('inAutoload');
?>