<?php namespace System\Core;

class Request {
    private static $instance = null;
    private $method;
    private $route;
    private $cookie;
    private $get;
    private $post;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->cookie = $_COOKIE;
        $this->get    = $_GET;
        $this->post   = $_POST;
    }

    public function all($bag = 'post')
    {
        return $this->$bag;
    }
    
    public function exists($key, $bag = 'post')
    {
        return array_key_exists($key, $this->$bag);
    }

    public function has($key, $bag = 'post')
    {
        return isset( $this->$bag[$key] );
    }

    public function get($key, $bag = 'post')
    {
        return $this->$bag[$key];
    }
    
    public function set($key, $value, $bag = 'post')
    {
        return $this->$bag[$key] = $value;
    }
    
    public function merge(array $array, $bag = 'post')
    {
        return array_merge($this->$bag, $array);
    }

    private function __clone(){}
    private function __wakeup(){}
}
