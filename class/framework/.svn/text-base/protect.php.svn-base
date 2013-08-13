<?php 

/**
 * Protect utility class for the CM framework
 * 
 * @author Michael Bates <michael@goquinella.com>
 * @package framework 
 */
class frameworkProtect {
  static function check() {
    if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION['uid']) || !$_SESSION['auth'])
      header('Location: /auth');
  }
}

?>
