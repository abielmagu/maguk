<?php require_once( realpath( dirname(__FILE__) .'/../vendor/autoload.php' ) );

$route = new \Xarvis\Route( new \Xarvis\Request() );
$service = new \Xarvis\Service($route);
var_dump($service->attend());