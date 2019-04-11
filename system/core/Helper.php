<?php namespace System\Core;

abstract class Helper
{
    static public function showme($data, $exit = true)
    {
        $shredded = '<pre>' . print_r($data, true) . '</pre>';
        if( $exit ) 
            return exit($shredded);
        
        return $shredded;
    }

    static public function crumble($data)
    {
        print_r( self::showme($data, false) );
    }
}
