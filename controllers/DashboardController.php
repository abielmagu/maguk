<?php namespace Controllers;

use System\Core\Request;
use System\Core\Controller;
use Models\Dashboard;

class DashboardController extends Controller {

    public function index()
    {
        echo 'Index Dashboard';
    }
}