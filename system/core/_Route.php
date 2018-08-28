<?php namespace System\Core;

class Route {

    private $url;
    private $controller;
    private $method;
    private $args;

    public function __construct( $queryUrl )
    {
        $url = explode('/', $queryUrl);
        $this->setController($url);
        $this->setMethod($url);
        $this->setArgs($url);
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getArgs()
    {
        return $this->args;
    }

    private function setController(&$url)
    {
        $this->controller = $this->shift($url);
    }

    private function setMethod(&$url)
    {
        $this->method = $this->shift($url);
    }

    private function setArgs(&$url)
    {
        $this->args = $url;
    }

    private function shift(&$array)
    {
        if( $array ) return array_shift($array);
        return null;
    }
}
