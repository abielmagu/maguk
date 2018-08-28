<?php namespace System\Core;

class Xarvis {
    private $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function attend()
    {
        $instance = $this->instanceControllerClass( $this->route->getController() );
        if( !$instance )
        {
            if( $url = config('redirect', 'home') )
            {
                redirect($url);
            }
            else
            {
                Exception::stop("Controller {$this->route->getController()} not exists");
            }
        }
  
        $method = $this->existsInstanceMethod($instance, $this->route->getMethod() );
        if( !$method )
            $method = 'index';
        
        $args = $this->existsMethodArgs( $this->route->getArgs() );
        if( $args )
        {
            return call_user_func_array([$instance, $method], $args);
        }
        else
        {
            return call_user_func([$instance, $method]);
        }
    }

    private function instanceControllerClass($name_controller)
    {
        $class_controller = Tool::upperFirstLetter($name_controller) . 'Controller';
        $path_controller = Config::get('path','controllers') . $class_controller . '.php';
        $finder_path_controller = new Finder($path_controller, false);

        if( $finder_path_controller->exists() )
        {
            $finder_path_controller->require();
            $controller_namespace = 'Controllers\\' . $class_controller;
            return new $controller_namespace();
        }
        return false;
    }

    private function existsInstanceMethod($instance, $method)
    {
        if( method_exists($instance, $method) && is_callable([$instance, $method]) )
        {
            return $method;
        }
        return false;
    }

    private function existsMethodArgs($args)
    {
        return is_array($args) && count($args) ? $args : false;
    }
}