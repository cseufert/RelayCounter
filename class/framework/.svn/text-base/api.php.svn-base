<?php 
/* 
 * API Base class for the CM Framework
 *
 * @author Christopher Seufert <seufert@gmail.com>
 * @author Michael Bates <michael@goquinella.com>
 * @package framework
 * @version $Revision: 321 $
 */
abstract class frameworkApi {
  /**
   * State Flag - OK - Api Method Performed as expected
   */
  CONST STATE_OK = 0x01;
  /**
   * State Flag - WARN - Api Method encountered an issue, but proceeded
   */
  CONST STATE_WARN = 0x02;
  /**
   * State Flag - ERROR - Api Method Failed to complete
   */
  CONST STATE_ERROR = 0x03;
  /**
   * Current Status from last API Method Call
   * @var integer
   */
  protected $state = 0x01;
  /**
   * Current Error from last API Method Call
   * @var string
   */
  protected $error = "";

  /**
   * Return API State
   * @return integer
   */
  function getState() {
    return $this->state;
  }
  /**
   * Return API Error Message
   * @return string
   */
  function getError() {
    return $this->error;
  }

  function doGet($param) {
    throw new Exception("Unimplemented API Method");
  }
  function doSet($param) {
    throw new Exception("Unimplemented API Method");
  }
  function doAdd($param) {
    throw new Exception("Unimplemented API Method");
  }
  function doCreate($param) {
    throw new Exception("Unimplemented API Method");
  }
  function doDelete($param) {
    throw new Exception("Unimplemented API Method");
  }
  
  function doAction($p, $type) {
    if(!isset($p['action'])) {
      $this->state = frameworkApi::STATE_ERROR;
      $this->error = "Missing parameter: 'Action'";
      return print_r($p, true);
    }
    $func = 'do' . ucfirst($type) . '_' . $p['action'];
    if(!method_exists(get_class($this), $func)) {
      $this->state = frameworkApi::STATE_ERROR;
      $this->error = "Invalid Action for this API: ".$p['action'];
      return print_r($p, true);
    }
    return call_user_func(array($this, $func), $p);
  }
  
  function requires(array $p, array $requires, &$error, &$errorcount) {
    $error = "Missing Parameter(s): ";
    $errorcount = 0;
    foreach($requires as $require) {
      if(!isset($p[$require])) {
        $error .= "'$require' ";
        $errorcount++;
      }
    }
    if($errorcount > 0)
      return false;
    return true;
  }
}
?>
