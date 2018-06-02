<?php

function address($string)
{
    return App\Url::address($string);
}

function redirect($string)
{
    return App\Url::redirect($string);
}

function view($resource, $data = null)
{
    return App\View::render($resource,$data);
}

function crumble($data)
{
    return App\Helper::crumble($data);
}

function showme()
{
    return App\Helper::showme($data);
}