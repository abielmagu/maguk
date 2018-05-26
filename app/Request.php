<?php namespace App;

class Request {

    private static $instance = null;
    private $url;
    private $get;
    private $post;
    private $cookie;

    public function __construct()
    {
        $this->route  = array_shift($_GET);
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->cookie = $_COOKIE;
    }

    static public function route()
    {
        if( is_null( self::$instance ) )
        {
            $self = self::getInstance();
        }
        return $self->route;
    }

    static public function getInstance()
    {
        if( is_null( self::$instance ) )
        {
            self::$instance = new Request();
        }
        return self::$instance;
    }

    private function __clone(){}
    private function __wakeup(){}
}
