<?php namespace Models;

use System\Core\Model;

class Auth extends Model
{
    protected $table = 'users';
    protected $timestamps = true;
    static private $salt = 'salt_to_value';

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
