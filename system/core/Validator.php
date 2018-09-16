<?php namespace System\Core;

abstract class Validator
{
    private $fails = [];
    
    protected function validate(array $data, array $list)
    {
        foreach($list as $keyname => $validations)
        {
            $rules = explode(';', $validations);
            foreach($rules as $rule)
            {
                $arguments = [];
                list($method, $filter) = $this->hasFilter($rule);
                $this->hasMethod($method);
                                
                if( $method === 'required' || $method === 'nullable' )
                {
                    array_push($arguments, $keyname, $data);
                }
                else
                {
                    if( isset($data[$keyname]) )
                    {
                        array_push($arguments, $data[$keyname]);
                        if( !is_null($filter) )
                            array_push($arguments, $filter);
                    }
                }
                
                if( !call_user_func_array([$this,$method], $arguments) )
                    array_push($this->fails, $keyname);
            }
        }
        
        return $this->response();
    }
    
    private function hasFilter($rule)
    {
        if( !strpos($rule,':') )
            return [$rule, null];
        
        list($fn, $filter) = explode(':', $rule);
        if( is_numeric($filter) )
            $filter = (int) $filter;
        
        return [$fn, $filter];
    }
    
    private function hasMethod($method)
    {
        if( !method_exists($this, $method) )
            Warning::stop("Validator method not exists: [{$method}]");
    }
    
    private function response()
    {
        if( count($this->fails) )
        {
            flash($this->fails);
            back();
        }
        return true;
    }
    
    //------------------------------------------------------------------------------------

    private function required($key, $array)
    {
        return isset( $array[$key] );
    }

    private function nullable($key, $array)
    {
        if( !array_key_exists($key, $array) || isset($array[$key]) )
            unset($this->fails[$key]);
        return true;
    }
    
    private function string($val)
    {
        return is_string($val);
    }
    
    private function email($val)
    {
        return filter_var($val, FILTER_VALIDATE_EMAIL);
    }
    
    private function integer($val)
    {
        return is_int($val);
    }
    
    private function max($val, $max)
    {
        if( $this->string($val) )
        {
            return strlen($val) <= $max; 
        }
        return $val <= $max;
    }

    private function min($val, $min)
    {
        if( $this->string($val) )
        {
            return strlen($val) >= $min; 
        }
        return $val >= $min;        
    }
}