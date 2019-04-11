<?php // HELPERS

function home_url(array $arguments = null)
{
    return System\Core\Url::getRoute('', $arguments);
}

function url($route, array $arguments = null)
{
    return System\Core\Url::getRoute($route, $arguments);
}

function redirect($string, array $arguments = null)
{
    return System\Core\Url::redirect($string, $arguments);
}

function back()
{
    return System\Core\Url::back();
}

function asset($path)
{
    return url("assets/{$path}");
}

function view($resource, $data = null)
{
    return System\Core\View::render($resource,$data);
}

function config($file, $key = null)
{
    return System\Core\Config::get($file,$key);
}

function path($finder)
{
    return System\Core\Path::root() . $finder;
}

function session_has($key, $subkey = null)
{
    return System\Core\Session::has($key, $subkey);
}

function session_exists($key, $subkey = null)
{
    return System\Core\Session::exists($key, $subkey);
}

function session_all()
{
    return System\Core\Session::all();
}

function session_get($key, $subkey = null)
{
    return System\Core\Session::get($key, $subkey);
}

function session_set($key, $val)
{
    return System\Core\Session::set($key, $val);
}

function session_erase($key)
{
    return System\Core\Session::erase($key);
}

function session_finish()
{
    return System\Core\Session::finish();
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

function stick($after, $content, $glue = '')
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

function percentage($part, $total, $decimals = 0)
{
    $result = ($part * 100) / $total;
    if( is_int($decimals) && $decimals > 0 )
        return round($result, $decimals);

    return (int) $result;
}

function convert_units($amount, $amount_measure, $to_convert)
{
    $lb_kg = 0.453;   // 1 Lb = 0.453 Kg
    $kg_lb = 2.204;   // 1 Kg = 2.204 Lb
    $inch_cm = 2.54;  // 1 Inch = 2.54 Cm
    $cm_inch = 0.393; // 1 Inch = 2.54 Cm

    if( $amount_measure === 'libras' && $to_convert === 'kilogramos')
        return $amount * $lb_kg;

    if( $amount_measure === 'kilogramos' && $to_convert === 'libras')
        return $amount * $kg_lb;

    if( $amount_measure === 'pulgadas' && $to_convert === 'centimetros')
        return $amount * $inch_cm;

    if( $amount_measure === 'centimetros' && $to_convert === 'pulgadas')
        return $amount * $cm_inch;

    return null;
}
