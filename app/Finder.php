<?php namespace App;

class Finder {

    private static $instance = null;
    private $thing;

    public function __construct($thing, $base = true)
    {
        if( !Tool::stringNotEmpty($thing) )
        {
            Exception::stop('Finder param is not string');
        }
        $this->thing = $base ? Path::base($thing) : $thing;
    }

    static public function get($thing, $base = true)
    {
        $self = new Finder($thing, $base);

        if( $self->exists() )
        {
            if( is_file($self->thing) )
            {
                return $self->require();
            }
            return $self->scan();
        }
        return false;
    }

    public function require()
    {
        return require($this->thing);
    }

    public function scan()
    {
        $scanned = scandir($this->thing);
        unset($scanned[0],$scanned[1]);
        return $scanned;
    }

    public function exists()
    {
        return file_exists($this->thing);
    }

    static public function getInstance($thing)
    {
        if( is_null( self::$instance ) )
        {
            self::$instance = new Finder($thing);
        }
        return self::$instance;
    }
    private function __clone(){}
    private function __wakeup(){}
}
