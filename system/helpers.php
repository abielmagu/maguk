<?php // HELPERS

function url($string, array $arguments = null)
{
    return System\Core\Url::generator($string, $arguments);
}

function address($string)
{
    return System\Core\Url::address($string);
}

function asset($path)
{
    $asset = 'assets/'.$path;
    return address($asset);
}

function redirect($string)
{
    return System\Core\Url::redirect($string);
}

function back()
{
    return System\Core\Url::back();
}

function view($resource, $data = null)
{
    return System\Core\View::render($resource,$data);
}

function config($file,$key = null)
{
    return System\Core\Config::get($file,$key);
}

function showme($data)
{
    return System\Core\Helper::showme($data);
}

function crumble($data)
{
    return System\Core\Helper::crumble($data);
}
