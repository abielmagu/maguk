<?php namespace Xarvis;

class Request {

    private $request = [];

    public function __construct()
    {
        $this->request['url']    = array_shift($_GET);
        $this->request['get']    = $_GET;
        $this->request['post']   = $_POST;
        $this->request['cookie'] = $_COOKIE;
    }

    public function input($input, $key = false)
    {
        if( is_string($input) && !empty($input) )
        {
            if( isset($this->request[$input]) )
            {
                if( $key && $key !== 'all' )
                {
                    if( isset($this->request[$input][$key]) )
                    {
                        return $this->request[$input][$key];
                    }
                }
                else
                {
                    return $this->request[$input];
                }
            }
        }
        return false;
    }

    public function url()
    {
        return $this->request['url'];
    }
}
