<?php namespace App;

class Config {

    static public function get($file)
    {
        $path = 'config/' . $file . '.php';
        return Finder::get($path);
    }
}