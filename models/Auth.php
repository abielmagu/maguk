<?php namespace Models;

use System\Core\Model;

class Auth extends Model
{
    static private $salt = 'join_salt_value';
    protected $table = 'users';
    protected $timestamps = true;

    static public function hashToSign($value)
    {
        $value_salt = $value . self::$salt;
        return hasher($value_salt);
    }

    static public function hashToCode($value)
    {
        $value_salt = $value . self::$salt;
        return sha1($value_salt);
    }
    
    static public function getSalt()
    {
        return self::$salt;
    }
}
