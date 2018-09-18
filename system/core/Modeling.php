<?php namespace System\Core;

class Modeling extends Model
{
    protected $table;
    
    public function __construct($table = null)
    {
        parent::__construct();
        $this->table = $table;
    }
}
