<?php namespace System\Core;

use System\Interfaces\iLayer;

abstract class Layer implements iLayer
{
    static public function isSigned()
    {
        return session_exists('user');
    }

    static public function identity(array $identities, $user)
    {
        $identified = array_filter($identities, function($i) use ($user) {
            return $i === $user;
        });
        return $identified;
    }
}
