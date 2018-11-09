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

function session_has($key)
{
    return System\Core\Session::has($key);
}

function session_exists($key)
{
    return System\Core\Session::exists($key);
}

function session_set($key, $val)
{
    return System\Core\Session::set($key, $val);
}

function session_get($key)
{
    return System\Core\Session::get($key);
}

function session_erase($key)
{
    return System\Core\Session::erase($key);
}

function flash($val)
{
    return System\Core\Session::flash($val);
}

function showme($data)
{
    return System\Core\Helper::showme($data);
}

function crumble($data)
{
    return System\Core\Helper::crumble($data);
}

function upperFirstLetter($str)
{
    return System\Core\Tool::upperFirstLetter($str);
}

function stick($after, $content, $glue = '-')
{
    return System\Core\Tool::stick($after, $content, $glue);
}

function getFilled(array $elements, array $keys)
{
    return System\Core\Tool::getFilled($elements, $keys);
}

function hasher($value)
{
    return System\Core\Hasher::hash($value);
}

function hasherVerify($value, $base)
{
    return System\Core\Hasher::verify($value, $base);
}
