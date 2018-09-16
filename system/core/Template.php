<?php namespace System\Core;

class Template 
{
    private $base;
    private $filling;
    private $spaces = [];

    public function __construct()
    {
        $this->base = Path::views();
    }

    public function extends($layout)
    {
        $template = $this;
        $layout_file = $this->base.$layout.'.php';
        return require($layout_file);
    }

    public function include($view)
    {
        $template = $this;
        $view_file = $this->base.$view.'.php';
        return include($view_file);
    }
    
    public function insert($view)
    {
        return include($this->base.$view.'.php');
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