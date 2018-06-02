<?php namespace App;

class Request {
    private static $instance = null;
    private $route;
    private $get;
    private $post;
    private $cookie;
    private $method;
    private $vars;

    private function __construct()
    {
        $this->route  = array_shift($_GET);
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->cookie = $_COOKIE;
        $this->method = Url::method();
        $this->vars   = $this->getMethodVars();
    }

    static public function getInstance()
    {
        if( is_null( self::$instance ) )
        {
            self::$instance = new Request();
        }
        return self::$instance;
    }

    static public function route()
    {
        self::getInstance();
        return self::$instance->route;
    }

    public function exists($key)
    {
        return array_key_exists($key, $this->vars);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->vars) && !empty( $this->vars[$key] );
    }

    public function all()
    {
        return $this->vars;
    }

    public function get($key)
    {
        return $this->vars[$key];
    }

    private function getMethodVars()
    {
        switch( $this->method )
        {
            case 'GET' : return $this->get;  break;
            case 'POST': return $this->post; break;
            default: return false;
        }
    }

    private function __clone(){}
    private function __wakeup(){}
}
