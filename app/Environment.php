<?php namespace App;

class Environment {

    static public function run()
    {
        self::loader();
        
        $env = Finder::get('env.php');
        self::debug($env);
        self::timer($env);
    }

    static private function loader()
    {
        require_once('system/constants.php');
        require_once('system/helpers.php');
    }

    static private function debug($env)
    {
        #ini_set('memory_limit', ($env['memory_limit']);

        ini_set('display_startup_errors', $env['display_startup_errors']);
        ini_set('display_errors', $env['display_errors']);
        ini_set('log_errors', $env['log_errors']);
        error_reporting($env['error_reporting']);
    }

    static private function timer($env)
    {
        date_default_timezone_set( $env['timezone'] );
        require_once('system/datetimes.php');
    }
}