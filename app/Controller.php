<?php namespace App;

use App\Request;

class Controller extends Validator
{
    protected $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }
}
