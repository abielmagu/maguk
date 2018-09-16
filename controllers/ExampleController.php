<?php namespace Controllers;

use System\Core\Request;
use System\Core\Controller;
use Models\Example;

class ExampleController extends Controller {
    
    public function index()
    {
        $example_model = new Example();
        $examples = $example_model->all();
        view('examples/index', compact('examples'));
    }

    public function store()
    {
        $example_model = new Example();
        $example_model->create( $this->request->all() );
        redirect('example');
    }

    public function update($id)
    {
        $example_model = new Example();
        $example_model->update($this->request->all(), $id);
        redirect('example');
    }

    public function delete($id)
    {
        $example_model = new Example();
        $example_model->delete($id);
        redirect('example');  
    }
}