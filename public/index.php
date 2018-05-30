<?php 
require_once( '../app/requires/defines.php' );
require_once( realpath( dirname(__FILE__).'/../vendor/autoload.php' ) );

use App\Environment;
use App\Route;
use App\Request;
use App\Xarvis;

Environment::run();
$route = new Route( Request::route() );
$xarvis = new Xarvis( $route );
$xarvis->attend();
