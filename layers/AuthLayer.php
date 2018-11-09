<?php namespace Layers;

class AuthLayer extends \System\Core\Layer
{
    static public function run( $action )
    {
        switch( $action )
        {
            case 'index':
            case 'signing':
                return self::notSigned();
                break;
        }
        return true;
    }

    static private function notSigned()
    {
        if( session_exists('user') )
            return redirect('');

        return true;
    }
}
