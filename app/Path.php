<?php namespace App;

abstract class Path
{
    static public function root()
    {
        return realpath( dirname( __FILE__ ) . DS . '..' . DS ) . DS;
    }

    static public function base($item)
    {
        return self::root() . $item;
    }
}