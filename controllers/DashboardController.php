<?php namespace Controllers;

use App\Controller;
use App\View;

class DashboardController extends Controller {
    
    public function index()
    {
        View::render('dashboard/index');
    }
}