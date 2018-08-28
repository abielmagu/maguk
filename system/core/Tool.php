<?php namespace System\Core;

abstract class Tool
{
    static public function stringNotEmpty($string)
    {
        return is_string($string) && !empty($string);
    }

    static public function upperFirstLetter($string)
    {
        return ucfirst( strtolower( $string ) );
    }
}