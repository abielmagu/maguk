<?php namespace App;

class Environment {

    static public function on()
    {
        $env = Finder::get('env.php');
        self::debug($env);
        self::app($env);
    }

    static public function debug($env)
    {
        ini_set('display_startup_errors', $env['display_startup_errors']);
        ini_set('display_errors', $env['display_errors']);
        error_reporting($env['error_reporting']);
    }

    static public function app($env)
    {
        date_default_timezone_set( $env['timezone'] );
    }
}