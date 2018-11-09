<?php
define('DS', DIRECTORY_SEPARATOR);
require_once( realpath( dirname(__FILE__).DS.'..'.DS.'vendor'.DS.'autoload.php' ) );

use System\Core\Environment;
use System\Core\Route;
use System\Core\Xarvis;

Environment::prepare();
$xarvis = new Xarvis( new Route() );
$xarvis->layers();
$xarvis->prepare();
$xarvis->attend();
