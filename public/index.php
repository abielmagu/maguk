<?php require_once( realpath( dirname(__FILE__).'/../vendor/autoload.php' ) );

use App\Route;
use App\Request;
use App\Xarvis;

$route = new Route( Request::route() );
$xarvis = new Xarvis( $route );
$xarvis->attend();
