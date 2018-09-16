<?php namespace System\Core;

use System\Interfaces\iController;

abstract class Controller extends Validator implements iController
{
    protected $request;

    public function __construct()
    {
        // code...
    }
}
