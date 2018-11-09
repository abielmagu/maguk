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
        $colors = [
            'primary'   => 'alert alert-primary',
            'secondary' => 'alert alert-secondary',
            'success'   => 'alert alert-success',
            'warning'   => 'alert alert-warning',
            'danger'    => 'alert alert-danger',
            'info'      => 'alert alert-info',
        ];

        if( !is_null($theme) )
        {
            flash([
                'message' => [
                    'color' => $colors[ $theme[0] ],
                    'text'  => $theme[1]
                ]
            ]);
        }
    }
}
