<?php namespace System\Core;

use System\Interfaces\iLayer;

abstract class Layer implements iLayer
{
    static public function identity(array $identities, $user)
    {
        $identified = array_filter($identities, function($i) use ($user) {
            return $i === $user;
        });
        return $identified;
    }
}
