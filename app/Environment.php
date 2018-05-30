<?php namespace App;

class Environment {

    static public function run()
    {
        $env = Finder::get('env.php');
        self::debug($env);
        self::app($env);
    }

    static private function debug($env)
    {
        ini_set('display_startup_errors', $env['display_startup_errors']);
        ini_set('display_errors', $env['display_errors']);
        error_reporting($env['error_reporting']);
    }

    static private function app($env)
    {
        date_default_timezone_set( $env['timezone'] );
        require_once('defines'.DS.'datetimes.php');
    }
}