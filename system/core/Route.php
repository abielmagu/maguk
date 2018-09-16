<?php namespace System\Core;

class Route {
    
    private $url;
    private $routes;
    private $default;
    private $address;
    private $slashes;
    private $resource;
    
    public function __construct()
    {
        $this->url = array_shift($_GET);
        $this->slashes = explode('/', $this->url);
        $this->routes = config('routes');
        
        $this->validate();
        
        $this->setRoutes();
        $this->setAddress();
        $this->setResource();
    }
    
    private function validate()
    {
        if( empty($this->url) && !isset($this->routes['default']) )
            Warning::stop('Empty url and route-default is not defined');
    }
    
    private function setRoutes()
    {            
        if( isset($this->routes['default']) )
        {
            $default = $this->routes['default'];
            $this->default = $this->routes[$default];
            unset($this->routes['default']);
        }
        
        if( !empty($this->slashes[0]) )
        {
            foreach($this->routes as $route => $action)
            {
                if( !preg_match("/({$this->slashes[0]})/", $route) )
                    unset( $this->routes[ $route ] );
            }
        }
        else
        {
            $this->slashes = [];
        }
    }
    
    private function setAddress()
    {
        $matching = 0;
        foreach($this->routes as $route => $action)
        {
            $strlen_route = strlen($route);
            $pattern = preg_quote($route, '/');
            if( preg_match("/({$pattern})/", $this->url) && $strlen_route >= $matching )
            {
                $this->address = $route;
                $matching = $strlen_route;
            }
        }

        if( is_null($this->address) && is_null($this->default) )
            Warning::stop('Route not exists');
    }
    
    private function setResource()
    {
        $action = !is_null($this->address) ? $this->routes[$this->address] : $this->default;
        
        list($controller, $method) = explode(':', $action);
        $this->resource['controller'] = $controller;
        $this->resource['method'] = $method;
        
        $arguments = array_filter($this->slashes, function ($slash) {
            return !preg_match("/({$slash})/", $this->address);
        });
        $this->resource['arguments'] = array_values($arguments);
    }
    
    public function getController()
    {
        return $this->resource['controller'];
    }
    
    public function getMethod()
    {
        return $this->resource['method'];
    }
    
    public function getArguments()
    {
        return $this->resource['arguments'];
    }
}