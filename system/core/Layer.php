<?php namespace System\Core;

use System\Interfaces\iLayer;

abstract class Layer implements iLayer
{
    static public function signed($type = null)
    {
        if( $signed = session_exists('user') )
        {
            if( !is_null($type) )
                $signed = session_get('user', 'type') === $type;
        }
        return $signed;
    }

    static public function unsigned($type = null)
    {
        return ! self::signed($type);
    }
    
    static public function only(array $only, $type)
    {
        $matched = array_filter($only, function($i) use ($type) {
            return $i === $type;
        });
        return $matched;
    }
}
