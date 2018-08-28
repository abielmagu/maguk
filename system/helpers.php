<?php

function address($string)
{
    return System\Core\Url::address($string);
}

function redirect($string)
{
    return System\Core\Url::redirect($string);
}

function view($resource, $data = null)
{
    return System\Core\View::render($resource,$data);
}

function crumble($data)
{
    return System\Core\Helper::crumble($data);
}

function showme()
{
    return System\Core\Helper::showme($data);
}

function config($file,$key)
{
    return System\Core\Config::get($file,$key);
}

function url($string, array $arguments  = [])
{
    return System\Core\Url::generator($string, $arguments);
}