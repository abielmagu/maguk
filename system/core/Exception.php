<?php namespace System\Core;

abstract class Exception
{
    static public function stop($message)
    {
        die(":{$message};");
    }
}