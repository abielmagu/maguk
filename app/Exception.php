<?php namespace App;

abstract class Exception
{
    static public function stop($message)
    {
        die(":{$message};");
    }
}