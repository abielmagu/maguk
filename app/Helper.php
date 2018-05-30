<?php //namespace App;

function url($string)
{
    $url = new App\Url();
    return $url->address($string);
}