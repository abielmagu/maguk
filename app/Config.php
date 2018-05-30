<?php namespace App;

abstract class Config {

    static public function get($config, $key = null)
    {
        $config_path = 'config'.DS.$config.'.php';
        $configs = Finder::get($config_path);

        if( !is_null($key) )
        {
            if( !array_key_exists($key,$configs) ) 
                Exception::stop("Config {$key} key not exists");
            
            return $configs[$key];
        }
        return $configs;
    }
}