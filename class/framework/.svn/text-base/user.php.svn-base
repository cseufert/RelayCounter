<?php 

/**
 * User base class for the CM framework
 * 
 * @author Michael Bates <michael@goquinella.com>
 * @package framework 
 */
class frameworkUser extends frameworkGenericOverload {
  
  protected $uid;
  
  protected $username;
  
  protected $password;
  
  protected $type;
  
  protected $parent;
  
  protected static $cache = array();
  
  static function getByUID($uid) {
    if(isset(self::$cache[$uid]))
      return self::open($uid);
    else {
      $q = "SELECT * FROM user WHERE uid = " . $uid;
      $row = stdDB::selectOne($q);
      self::fillCache($row);
      return self::open($uid);
    }
  }
  
  static function getMe() {
    @session_start();
    if(!isset($_SESSION['uid']))
      throw new frameworkUser_Exception_NoSession("Unable to determine current user.");
    if(!isset(self::$cache[$_SESSION['uid']])) {
      $q = "SELECT * FROM user WHERE uid = " . $_SESSION['uid'];
      $row = stdDB::selectOne($q);
      self::fillCache($row);
    }
    return self::open($_SESSION['uid']);
  }
  
  static function fillCache($row) {
    $t = get_called_class();
    self::$cache[$row['uid']] = array("username"=>$row['username'],
                                      "password"=>$row['password'],
                                      "type"=>$row['type'],
                                      "parent"=>$row['parentuid'] != 0 ? $t::getByUID($row['parentuid']) : false);
    $t::fillCacheExtra(self::$cache, $row);
  }
  
  static function open($uid) {
    $t = get_called_class();
    $o = new $t();
    $o->uid = $uid;
    $o->username = self::$cache[$uid]['username'];
    $o->password = self::$cache[$uid]['password'];
    $o->type     = self::$cache[$uid]['type'];
    $o->parent   = self::$cache[$uid]['parent'];
    $t::openExtra($o, $uid);
    return $o;
  }
  
  function getUID() {
    return $this->uid;
  }
  
  function getUsername() {
    return $this->username;
  }
  
  function getPassword() {
    return $this->password;
  }
  
  static function fillCacheExtra(&$cache, $row) {
    return true;
  }
  
  static function openExtra(&$o, $uid) {
    return true;
  }
  
  static function check($username, $password) {
    $q = "SELECT * FROM user WHERE username = '".$username."' AND password = '".sha1($password)."'";
    $r = stdDB::query($q);
    if(mysql_num_rows($r) == 1)
      return true;
    return false;
  }
  
  static function auth($uid) {
    if(!isset($_SESSION)) session_start();
    $_SESSION['uid'] = $uid;
    $_SESSION['auth'] = true;
  }
  
}

class frameworkUser_Exception_NoSession extends Exception {
  
}
?>
