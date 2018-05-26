<?php namespace App;

class Xarvis {
    private $route;

    public function __construct($route)
    {
        Environment::on();
        $this->route = $route;
    }

    public function attend()
    {
        $instance = $this->instanceControllerClass( $this->route->getController() );
        if( !$instance )
        {
            die(': Controller not exists;');
        }
        
        $method = $this->existsInstanceMethod($instace, $this->route->getMethod() );
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

    private function instanceControllerClass($nameController)
    {
        $classController = ucfirst( strtolower( $nameController ) ).'Controller';
        $pathController = Config::get('path')['controllers'] . $classController.'.php';
        if( Finder::exists($pathController) && Finder::readable($pathController) )
        {
            Finder::get($pathController);
            return new $classController();
        }
        return false;
    }

    private function existsInstanceMethod($instance, $method)
    {
        return method_exists($instance, $method) && is_callable([$instance, $method]) ? $method : false;
    }

    private function existsMethodArgs($args)
    {
        return is_array($args) && count($args) ? $args : false;
    }
}