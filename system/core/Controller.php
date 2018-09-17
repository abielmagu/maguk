<?php namespace System\Core;

use System\Interfaces\iController;

abstract class Controller extends Validator implements iController
{
    public function __construct()
    {
        // code...
    }
    
    protected function message($theme)
    {
        if( !is_null($theme) )
        {
            flash([
                'color' => 'alert alert-'.$theme[0],
                'message' => $theme[1]
            ]);
        }
    }
}
