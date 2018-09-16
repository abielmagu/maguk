<?php namespace System\Core;

abstract class Session {
    
    static public function start()
    {
        return session_start();
    }
    
    static public function sid()
    {
        return session_id();
    }
    
    static public function all()
    {
        return $_SESSION;
    }
    
    static public function has($key)
    {
        return isset( $_SESSION[$key] );
    }
    
    static public function exists($key)
    {
        return array_key_exists($key, $_SESSION);
    }
    
    static public function get($key)
    {
        if( self::has($key) )
            return $_SESSION[$key];
        return false;
    }
    
    static public function set($key, $val)
    {
        if($key <> 'flash')
            return $_SESSION[$key] = $val;
        Warning::stop('[flash] is reserved word, use another');
    }
    
    static public function flash($val)
    {
        return $_SESSION['flash'] = $val;
    }
    
    static public function erase($key)
    {
        if( self::exists($key) )
            unset($_SESSION[$key]);
        return true;
    }
    
    static public function destroy()
    {
        $_SESSION = [];
        return session_destroy();
    }
}