<?php namespace System\Core;

class Environment {

    static private $env;
    
    static public function prepare()
    {
        self::$env = require( Path::root().'env.php' );
        
        self::debug();
        self::timer();
        self::requires();
        Session::start();
    }

    static private function debug()
    {
        #ini_set('memory_limit', $env['memory_limit']);
        ini_set('display_startup_errors', self::$env['display_startup_errors']);
        ini_set('display_errors', self::$env['display_errors']);
        ini_set('log_errors', self::$env['log_errors']);
        error_reporting(self::$env['error_reporting']);
    }

    static private function timer()
    {
        date_default_timezone_set( self::$env['timezone'] );
        require_once( Path::system().'datetimes.php' );
    }
    
    static private function requires()
    {
        require_once( Path::system().'defines.php' );
        require_once( Path::system().'helpers.php' );
    }
}