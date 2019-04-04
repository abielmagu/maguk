<?php namespace System\Core;

class Request {
    private static $instance = null;
    private $method;
    private $bags = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->bags['COOKIE'] = $_COOKIE;
        $this->bags['GET'] = $_GET;
        $this->bags['POST'] = $_POST;
    }

    public function all($bag = 'post')
    {
        return $this->bags[ strtoupper($bag) ];
    }
    
    public function exists($key, $bag = 'post')
    {
        return array_key_exists($key, $this->bags[ strtoupper($bag) ]);
    }

    public function has($key, $bag = 'post')
    {
        return isset( $this->bags[ strtoupper($bag) ][$key] );
    }

    public function isEmpty($key, $bag = 'post')
    {
        return empty( trim($this->bags[ strtoupper($bag) ][$key]) );
    }
    
    public function get($key, $bag = 'post')
    {
        return $this->bags[ strtoupper($bag) ][$key];
    }
    
    public function set($key, $value, $bag = 'post')
    {
        return $this->bags[ strtoupper($bag) ][$key] = $value;
    }
    
    public function merge(array $array, $bag = 'post')
    {
        return array_merge($this->bags[ strtoupper($bag) ], $array);
    }

    public function erase($key, $bag = 'post')
    {
        if( $this->exists($key) )
            unset( $this->bags[ strtoupper($bag) ][$key] );
        return true;
    }
    
    private function __clone(){}
    private function __wakeup(){}
}
