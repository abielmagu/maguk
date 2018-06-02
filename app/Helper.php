<?php namespace App;

abstract class Helper
{
    static public function crumble($data, $die = true)
    {
        $shredded = '<pre>' . print_r($data, true) . '</pre>';
        if( $die ) die($shredded);
        return $shredded;
    }

    static public function showme($data)
    {
        print_r( self::crumble($data, false) );
    }
}