<?php namespace System\Core;

class View 
{
    static public function render($resource, array $data = null)
    {
        $view_path = self::viewPath($resource);
        
        if( self::validateData($data) )
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

    static private function validateData($data)
    {
        if( is_array($data) )
        {
            return true;
        }
        elseif( !is_null($data) )
        {
            Exception::stop('Data view must a be array param');
        }
        else
        {
            return false;
        }
    }

    static private function viewsBase()
    {
        return Config::get('path', 'views');
    }
}
