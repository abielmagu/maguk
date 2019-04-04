<?php namespace System\Core;

abstract class Validator
{
    private $fails = [];
    private $validations;
    
    protected function validate(array $data, array $list)
    {
        $this->validations = config('validations');
        
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
                elseif( $method === 'unique' )
                {
                    if( isset($data[$keyname]) )
                        array_push($arguments, $keyname, $data[$keyname], $filter);
                }
                elseif( $method === 'equal' )
                {
                    array_push($arguments, $keyname, $filter, $data);
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
                {
                    if( isset($this->validations[$method]) )
                    {
                        $explain = $this->validations[$method];
                        $limiter = is_numeric($filter) ? $filter : '';
                        $notice = "{$keyname}:  {$explain} {$limiter}";
                        array_push($this->fails, $notice);
                    }
                    else
                    {
                        array_push($this->fails, $keyname);
                    }                    
                }
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
            session_set('errors', $this->fails);
            return back();
        }
        return true;
    }
    
    //------------------------------------------------------------------------------------

    private function required($key, $array)
    {
        return isset( $array[$key] ) && !empty( trim($array[$key]) );
    }

    private function notempty($val)
    {
        return !empty( trim($val) );
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
            return strlen($val) <= $max; 
        
        return $val <= $max;
    }

    private function min($val, $min)
    {
        if( $this->string($val) )
            return strlen($val) >= $min;
        
        return $val >= $min;        
    }

    private function equal($A, $B, $array)
    {
        if( isset( $array[$A] ) && isset( $array[$B] ) )
            return $array[$A] === $array[$B];

        return false;
    }
    
    private function unique($column, $data, $table_with_except)
    {
        if( strpos($table_with_except,'-') )
        {
            list($table, $except) = explode('-', $table_with_except);
            list($prop, $value) = explode(',', $except) ;
        }
        else
        {
            $table = $table_with_except;
        }
        
        $model = new Modeling($table);
        $result = $model->find($data, $column);
        
        if( is_object($result) )
        {
            if( isset($prop) && $result->$prop === $value )
                return true;
            
            return false;
        }
        return true;
    }
}
