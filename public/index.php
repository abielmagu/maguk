<?php 

require_once( realpath( dirname(__FILE__).'/../vendor/autoload.php' ) );

use System\Core\Environment;
use System\Core\Route;
use System\Core\Xarvis;

Environment::prepare();
$xarvis = new Xarvis( new Route() );
$xarvis->attend();
