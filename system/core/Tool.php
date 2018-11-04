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
    
    static public function stick($after, $content, $glue = '-')
    {
        return $after.$glue.$content;
    }
    
    static public function getFilled(array $elements, array $keys)
    {
        $filled = [];
        foreach($keys as $key)
        {
            if( isset($elements[$key]) && !empty($elements[$key]) )
                array_push($filled, $key);
        }
        return $filled;        
    }
}
