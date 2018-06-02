<?php namespace Controllers;

use App\Controller;
use Models\Guest;

class DashboardController extends Controller {
    
    public function index()
    {
        $guest_model = new Guest();
        $guests = $guest_model->all();
        view('dashboard/index', compact('guests'));
    }

    public function store()
    {
        $guest_model = new Guest();
        $guest_model->create( $this->request->all() );
        redirect('dashboard');
    }

    public function update($id)
    {
        $guest_model = new Guest();
        $guest_model->update($this->request->all(), $id);
        redirect('dashboard');
    }

    public function delete($id)
    {
        $guest_model = new Guest();
        $guest_model->delete($id);
        redirect('dashboard');  
    }
}