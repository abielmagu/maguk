<?php namespace Layers;

use System\Core\Layer;

class ExampleLayer extends Layer
{
    static public function run( $action )
    {
        if( self::isSigned() )
        {
            $user = session_get('user');
            $types = ['admin','common'];
            if( self::identify($types, $user['type']) )
            {
                return true;
            }
            else
            {
                return redirect('');
            }
        }

        return redirect('sign');
    }
}
