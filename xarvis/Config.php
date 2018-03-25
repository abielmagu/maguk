<?php namespace Xarvis;

class Config {

    static public function get($file)
    {
        $path = 'config/' . $file . '.php';
        return Finder::get($path);
    }
}