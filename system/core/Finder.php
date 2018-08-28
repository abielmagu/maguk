<?php namespace System\Core;

class Finder {

    private $directory = null;
    private $file = null;

    public function __construct($directory = null)
    {
        if( is_string($directory) )
        {
            $path = BASE.$directory;
            if( file_exists($path) && is_dir($path) )
            {
                $this->directory = $path;
            }
        }
    }

    public static function exists($path)
    {
        return file_exists( BASE.$path );
    }
    
    public function scan()
    {
        if( !is_null($this->directory) )
        {
            $scanned = scandir($this->directory);
            unset($scanned[0],$scanned[1]);
            return $scanned;    
        }
        return false;
    }
    
    public function count()
    {
        $scanned = $this->scan();
        if( is_array($scanned) )
        {
            return count( $scanned );  
        }
        return false;
    }

    public static function require($file, $once = false)
    {
        $path = BASE.$file;
        if( is_file($path) )
        {
            if( $once && require_once($path) )
            {
                return true;
            }
            return require( BASE.$file );
        }
        return false;
    }
    
    public static function get($path)
    {
        if( is_string($path) && self::exists($path) )
        {
            if( is_dir($path) )
            {
                self::$instance = new self($path);
                $scanned = self::$instance->scan();
                unset( self::$instance );
                return $scanned;
            }
            return self::require($path);
        }
        return false;
    }
    
    private function __clone(){}
    private function __wakeup(){}
}
