<?php namespace System\Core;

class Template 
{
    private $base;
    private $filling;
    private $spaces = [];

    public function __construct($base)
    {
        $this->base = $base;
    }

    public function extends($layout)
    {
        $template = $this;
        $layout_file = $this->base.$layout.'.php';
        return require($layout_file);
    }

    public function include($subview)
    {
        $template = $this;
        $subview_file = $this->base.$subview.'.php';
        return include($subview_file);
    }

    public function space($filled)
    {
        return $this->spaces[ $filled ];
    }

    public function fill($space_name)
    {
        $this->filling = $space_name;
        ob_start();
    }

    public function stop()
    { 
        $this->spaces[ $this->filling ] = ob_get_contents();
        ob_end_clean();
        return $this->spaces[ $this->filling ];
    }
}