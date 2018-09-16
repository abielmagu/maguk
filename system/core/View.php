<?php namespace System\Core;

abstract class View 
{
    static public function render($resource, array $data = null)
    {
        if( self::validate($data) )
            extract($data);
        
        $resource_path = self::path($resource);
        $template = new Template();
        require_once( $resource_path );
    }

    static private function path($resource)
    {
        $resource_path = Path::views().$resource.'.php';
        if( !is_file($resource_path) )
            Warning::stop("View {$resource} not exists");

        return $resource_path;
    }

    static private function validate($data)
    {
        if( is_array($data) )
        {
            return count($data);
        }
        if( is_null($data) )
        {
            return false;
        }
        else
        {
            Warning::stop('Data view must a be array param');
        }
    }
}
