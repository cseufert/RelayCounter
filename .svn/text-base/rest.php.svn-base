<?php
/**
 * Attempt at a RESTful API for interaction between web clients and iNewsletter
 *
 * @author Michael Bates <michael@goquinella.com>
 * @author Christopher Seufert <seufert@gmail.com>
 * @package komma
 * @version $Revision: 148 $
 */
require_once("class/autoload.php");
function json_return($state, $err, $data = "") {
  $err .= ob_get_contents();
  ob_end_clean();
  if(strlen($err))
    $state = ($state == frameworkApi::STATE_OK)?frameworkApi::STATE_WARN:$state;
  $stateText = Array(frameworkApi::STATE_OK => "OK", frameworkApi::STATE_WARN => "WARN",
          frameworkApi::STATE_ERROR=>"ERR");
  $state = $stateText[$state];
  return json_encode(Array("S"=>$state, "E"=>$err, "D"=>$data));
}
ob_start();
if(!isset($_REQUEST['T']))
  die(json_return(frameworkApi::STATE_ERROR,"Invalid Request Type (T)"));
if(!isset($_REQUEST['M']) || !in_array(strtolower($_REQUEST['M']),Array("get","set","add","create","delete")))
  die(json_return(frameworkApi::STATE_ERROR,"Invalid Request Method (M)"));
$apiName = "api" . ucfirst($_REQUEST['T']);
$api = new $apiName();
$apiMethod = "do".ucfirst($_REQUEST['M']);
Try {
  $out = $api->$apiMethod($_REQUEST);
  echo json_return($api->getState(), $api->getError(), $out);
} Catch( Exception $e) {
  echo json_return($api->getState(), "Exception: ".$e->getMessage().
          "\n".$e->getTraceAsString()."\n".$api->getError());
}
?>