<?php
require_once('class/autoload.php');
if(!isset($_REQUEST['class']))
  $class_view = FIRSTVIEW;
else
  $class_view = $_REQUEST['class'];
$class = 'view' . ucfirst($class_view);
if(!class_exists($class))
  die("Could not load the specified class: $class");
$tpl = isset($_REQUEST['tpl']) ? $_REQUEST['tpl'] : false;
if(isset($_REQUEST['id']))
  $view = $class::load($_REQUEST['id'], $tpl);
else
  $view = $class::load(false, $tpl);
$view->loadTemplate();
echo $view;
?>
