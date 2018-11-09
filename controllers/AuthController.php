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
        return true;
    }

    public function signout()
    {
        return true;
    }
}
