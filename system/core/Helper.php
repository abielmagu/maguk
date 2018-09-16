<?php namespace System\Core;

abstract class Helper
{
    static public function showme($data, $die = true)
    {
        $shredded = '<pre>' . print_r($data, true) . '</pre>';
        if( $die ) die($shredded);
        return $shredded;
    }

    static public function crumble($data)
    {
        print_r( self::showme($data, false) );
    }
}