<?php namespace System\Core;

class Xarvis {
    
    private $route;
    private $instance;
    private $method;
    private $arguments;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function layers()
    {
        $route_controller = $this->route->getController();
        $layers = config('layers');

        if( array_key_exists($route_controller, $layers) )
        {
            $layer_name = $layers[ $route_controller ];
            $layer_path = Path::layers() . $layer_name . '.php';

            if( file_exists($layer_path) )
            {
                require_once $layer_path;
                $layer_class = 'Layers\\'.$layer_name;
                return $layer_class::run( $this->route->getMethod() );
            }
            else
            {
                Warning::stop('Layer not exists');
            }
        }
        return true;
    }

    public function prepare()
    {
        $this->instance  = $this->instanceController();
        $this->method    = $this->controllerMethod();
        $this->arguments = $this->route->getArguments();
    }
    
    public function attend()
    {        
        if( $this->arguments )
            return call_user_func_array([$this->instance, $this->method], $this->arguments);

        return call_user_func([$this->instance, $this->method]);
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
    
    private function controllerMethod()
    {
        $method = $this->route->getMethod();
        if( method_exists($this->instance, $method) && is_callable([$this->instance, $method]) )
            return $method;
        
        return 'index';
    }
}
