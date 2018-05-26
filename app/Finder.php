<?php namespace App;

class Finder {

    static private function validate($thing)
    {
        return is_string($thing) && !empty($thing);
    }

    static public function get($thing)
    {
        if( self::exists($thing) )
        {   
            $path = self::path($thing);
            if( is_file($path) )
            {
                return self::require($path);
            }
            return self::scan($path);
        }
        return false;
    }

    static public function exists($thing)
    {
        if( self::validate($thing) )
            return file_exists( self::path($thing) );
        return false;
    }

    static public function path($thing)
    {
        return self::rootpath() . $thing;
    }

    static public function require($path)
    {
        if( self::validate($path) )
            return require($path);
        return false;
    }

    static public function scan($path)
    {
        if( self::validate($path) )
        {
            $scanned = scandir($path);
            unset($scanned[0], $scanned[1]);
            return $scanned;
        }
        return false;
    }

    static public function readable($thing)
    {
        return is_readable( self::path($thing) );
    }

    static public function rootpath()
    {
        return realpath( dirname( __DIR__ . '../' ) ) . DIRECTORY_SEPARATOR;
    }
}