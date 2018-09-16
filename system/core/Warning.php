<?php namespace System\Core;

abstract class Warning
{
    static public function stop($message)
    {
        die("Xarvis: {$message};");
    }
}