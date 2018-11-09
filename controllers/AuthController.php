<?php namespace Controllers;

use System\Core\Controller;
use System\Core\Request;
use Models\Auth;

class AuthController extends Controller {

    public function index()
    {
        return view('auth/index');
    }

    public function signing()
    {
        $request = new Request;
        $this->validate($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->get('username');
        $model = new Auth;
        if( $user = $model->find($username, 'email') )
        {
            $password = $request->get('password') . Auth::getSalt();
            if( hasherVerify($password, $user->password) )
            {
                $props = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'type' => $user->type,
                ];
                session_set('user', $props);
                return redirect('');
            }
        }
        
        // $this->message(['danger', 'Wrong username or password']);
        flash('not_auth');
        return back();
    }

    public function signout()
    {
        session_finish();
        return redirect('sign');
    }
}
