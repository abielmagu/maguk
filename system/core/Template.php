<?php namespace System\Core;

class Template 
{
    private $views;
    private $filling;
    private $spaces = [];

    public function __construct()
    {
        $this->views = Path::views();
    }

    public function expand($layout)
    {
        $template = $this;
        $grid = $this->views.$layout.'.php';
        return require($grid);
    }
    
    public function insert($view)
    {
        return include($this->views.$view.'.php');
    }

    public function space($filled)
    {
        return $this->spaces[ $filled ];
    }

    public function fill($spacename)
    {
        $this->filling = $spacename;
        ob_start();
    }

    public function stop()
    { 
        $this->spaces[ $this->filling ] = ob_get_contents();
        ob_end_clean();
        return $this->spaces[ $this->filling ];
    }
}