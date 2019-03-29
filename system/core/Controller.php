<?php namespace System\Core;

use System\Interfaces\iController;
use System\Core\Request;

abstract class Controller extends Validator implements iController
{
    protected $request;
    
    public function __construct()
    {
        $this->request = new Request;
        // code...
    }
    
    protected function message($theme)
    {
        if( is_array($theme) )
        {
            return flash([
                'message' => [
                    'status' => $theme[0],
                    'text'  => $theme[1]
                ]
            ]);
        }

        Warning::stop('Message param must be array');
    }
}
