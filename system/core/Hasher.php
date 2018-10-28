<?php namespace System\Core;

abstract class Hasher
{
    static public function hash($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    static public function verify($value, $base)
    {
        return password_verify();
    }
}
