<?php namespace System\Core;

class Request {
    private static $instance = null;
    private $method;
    private $bags = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->bags['cookie'] = $_COOKIE;
        $this->bags['get'] = $_GET;
        $this->bags['post'] = $_POST;
    }

    public function all($bag = 'post')
    {
        return $this->bags[$bag];
    }
    
    public function exists($key, $bag = 'post')
    {
        return array_key_exists($key, $this->bags[$bag]);
    }

    public function has($key, $bag = 'post')
    {
        return isset( $this->bags[$bag][$key] );
    }

    public function void($key, $bag = 'post')
    {
        return empty( $this->bags[$bag][$key] );
    }
    
    public function get($key, $bag = 'post')
    {
        return $this->bags[$bag][$key];
    }
    
    public function set($key, $value, $bag = 'post')
    {
        return $this->bags[$bag][$key] = $value;
    }
    
    public function merge(array $array, $bag = 'post')
    {
        return array_merge($this->bags[$bag], $array);
    }

    public function erase($key, $bag = 'post')
    {
        if( $this->exists($key) )
            unset( $this->bags[$bag][$key] );
        return true;
    }
    
    private function __clone(){}
    private function __wakeup(){}
}
