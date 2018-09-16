<?php namespace System\Core;

class Xarvis {
    
    private $route;
    
    public function __construct(Route $route)
    {
        $this->route = $route;
    }
    
    public function attend()
    {
        $instance  = $this->instanceController();
        $method    = $this->controllerMethod($instance);
        $arguments = $this->route->getArguments();
        
        if( $arguments )
            return call_user_func_array([$instance, $method], $arguments);

        return call_user_func([$instance, $method]);
    }
    
    private function instanceController()
    {
        $controller = $this->route->getController();
        $controller_path = Path::controllers().$controller.'.php';
        if( file_exists($controller_path) )
        {
            require_once($controller_path);
            $controller_class = 'Controllers\\'.$controller;
            return new $controller_class();
        }
        Warning::stop('Controller not exists');
    }
    
    private function controllerMethod($instance)
    {
        $method = $this->route->getMethod();
        if( method_exists($instance, $method) && is_callable([$instance, $method]) )
            return $method;
        
        return 'index';
    }
}
