<?php namespace Controllers;

use System\Core\Request;
use System\Core\Controller;
use Models\Example;

class ExampleController extends Controller {
    
    public function index()
    {
        $example_model = new Example();
        $examples = $example_model->all();
        return view('examples/index', compact('examples'));
    }
    
    public function create()
    {
        // code
    }
    
    public function store()
    {
        $example_model = new Example();
        $example_model->create( $this->request->all() );
        return redirect('example');
    }

    public function edit($id = null)
    {
        // code
    }
    
    public function update($id = null)
    {
        $example_model = new Example();
        $example_model->update($this->request->all(), $id);
        return redirect('example');
    }

    public function warning($id = null)
    {
        // code
    }
    
    public function delete($id = null)
    {
        $example_model = new Example();
        $example_model->delete($id);
        return redirect('example');  
    }
}
