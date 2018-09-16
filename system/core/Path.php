<?php namespace System\Core;

abstract class Path
{
    static public function root()
    {
        return realpath( dirname(__FILE__) . DS.'..'.DS.'..'.DS ) . DS;
    }
    
    static public function system()
    {
        return self::root().'system'.DS;
    }
    
    static public function config()
    {
        return self::root().'config'.DS;
    }
    
    static public function controllers()
    {
        $path = config('paths', 'controllers');
        return self::root().$path;
    }
    
    static public function models()
    {
        $path = config('paths', 'models');
        return self::root().$path;      
    }

    static public function views()
    {
        $path = config('paths', 'views');
        return self::root().$path;      
    }
}
