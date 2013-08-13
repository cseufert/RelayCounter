<?php
/**
 * JSON <-> Komma Gateway
 *
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
if(!isset($_REQUEST['M']) || !in_array($_REQUEST['M'],Array("Get","Set","Add","Create")))
  die(json_return(frameworkApi::STATE_ERROR,"Invalid Request Method (M)"));
$apiName = "api" . $_REQUEST['T'];
$api = new $apiName();
$apiMethod = "do".$_REQUEST['M'];
Try {
  $out = $api->$apiMethod(isset($_REQUEST['P'])?$_REQUEST['P']:Array());
  echo json_return($api->getState(), $api->getError(), $out);
} Catch( Exception $e) {
  echo json_return($api->getState(), "Exception: ".$e->getMessage().
          "\n".$e->getTraceAsString()."\n".$api->getError());
}
?>