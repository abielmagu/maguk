<?php namespace Controllers;

use Models\Auth;

class AuthController extends \System\Core\Controller {

    public function index()
    {
        return view('auth/index');
    }

    public function signing()
    {
        $this->validate($this->request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $this->request->get('username');
        $model = new Auth;
        if( $user = $model->find($username, 'email') )
        {
            $password = $this->request->get('password') . Auth::getSalt();
            if( hasherVerify($password, $user->password) )
            {
                session_set('user', [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'type' => $user->type,
                ]);
                
                // You can set a function 'home' to redirect for type user
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
