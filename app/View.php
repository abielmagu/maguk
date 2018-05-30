<?php namespace App;

class View 
{
    static public function render($resource, array $data = null)
    {
        $view_path = self::viewPath($resource);
        
        if( self::validationRenderData($data) )
            extract($data);
        
        $template = new Template( self::viewsBase() );
        require_once($view_path);
    }

    static private function viewPath($resource)
    {
        $resource_path = self::viewsBase() . $resource . '.php';

        if( !is_file($resource_path) )
            Exception::stop("View {$resource} not exists");

        return $resource_path;
    }

    static private function validationRenderData($data)
    {
        if( !is_null($data) )
        {
            if( !is_array($data) )
            {
                Exception::stop('Data view must a be array param');
                return false;
            }
            return true;
        }
        return false;
    }

    static private function viewsBase()
    {
        return Config::get('path', 'views');
    }
}
