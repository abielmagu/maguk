<?php namespace System\Core;

use \PDO;
use \PDOException;

abstract class Model
{
    protected $pdo;
    protected $query;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function all($order = 'DESC')
    {
        $this->query = "SELECT * FROM {$this->table} ORDER BY id {$order}";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function availables()
    {
        $this->query = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY id {$order}";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function where($column, $operator, $value)
    {
        $PDOParam = $this->getPDOParam($value);
        $this->query = "SELECT * FROM {$this->table} WHERE {$column} {$operator} :value";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':value', $value, $PDOParam);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function whereIn($column, array $values)
    {
        $positions = $this->getWhereInPositions($values);
        $this->query = "SELECT * FROM {$this->table} WHERE {$column} IN ({$positions})";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute( $values );
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function between($column, $min, $max, $negative = false)
    {
        $PARAM_min = is_string($min) ? PDO::PARAM_STR : PDO::PARAM_INT;
        $PARAM_max = is_string($max) ? PDO::PARAM_STR : PDO::PARAM_INT;
        $NOT = $negative ? 'NOT' : '';

        $this->query = "SELECT * FROM {$this->table} WHERE {$column} {$NOT} BETWEEN :min AND :max";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':min', $min, $PARAM_min);
        $stmt->bindValue(':max', $max, $PARAM_max);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function search($column, $value)
    {
        $this->query = "SELECT * FROM {$this->table} WHERE column LIKE :value";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':column', $column, PDO::PARAM_STR);
        $stmt->bindValue(':value', $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function find($value, $column = 'id')
    {
        $PDOParam = $this->getPDOParam($value);
        $this->query = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);      
    }

    public function available($value, $column = 'id')
    {
        $PDOParam = $this->getPDOParam($value);
        $this->query = "SELECT * FROM {$this->table} WHERE {$column} = :value AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function exists($column, $value, array $except = null)
    {
        if( is_array($except) )
        {
            $except_column = key($except);
            $except_value = $except[ $except_column ];
            $this->query = "SELECT count(*) FROM {$this->table}
                            WHERE {$column} = {$value} AND {$except_column} <> {$except_value} 
                            LIMIT 1";
        }
        else
        {
            $this->query = "SELECT count(*) FROM {$this->table}
                            WHERE {$column} = $value 
                            LIMIT 1";
        }
        
        $stmt = $this->pdo->prepare( $this->query );
        
        if( $stmt->execute() )
            return $stmt->fetchColumn();
        
        return false;
    }

    public function store(array $data)
    {
        if( $this->hasTimestamps() )
        {
            $timestamps = [
                'created_at' => DATETIME_NOW,
                'updated_at' => DATETIME_NOW
            ];
            $data = array_merge($data, $timestamps);
        }
        $this->query = $this->getQueryInsert($data);
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute( array_values($data) );
        return $this->lastInsert();
    }

    public function update(array $data, $id)
    {
        if( $this->hasTimestamps() )
        {
            $timestamps = [
                'updated_at' => DATETIME_NOW
            ];
            $data = array_merge($data, $timestamps);
        }
        
        $this->query  = $this->getQueryUpdate($data);
        $this->query .= " WHERE id = ? LIMIT 1";
        $stmt = $this->pdo->prepare( $this->query );
        array_push($data, $id);
        $stmt->execute( array_values($data) );
        return $stmt->rowCount();
    }
    
    public function deleteSoft($id)
    {
        $this->query  = "UPDATE {$this->table} 
                         SET deleted_at = :deleted 
                         WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':deleted', DATETIME_NOW);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $this->query = "DELETE FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function unduplicated($action, array $data, array $find, array $except = null)
    {
        // $data = [data, |id]
        // $find = [column => value] 
        // $except = [prop => value]
        
        $column = key($find);
        $found = call_user_func_array([$this,'find'], [$find[$column], $column]);
        $prop = is_array($except) ? key($except) : false;
        
        if( !is_object($found) || is_string($prop) && $found->$prop === $except[$prop] )
        {
           return call_user_func_array([$this,$action], $data);
        }
        return $found;
    }

    public function raw($query, $fetch = false)
    {
        $this->query = $query;
        $stmt = $this->pdo->prepare( $this->query );
        
        if( $executed = $stmt->execute() )
        {
            if( $fetch )
            {
                $fetched = $stmt->fetchAll(PDO::FETCH_OBJ);
                return count($fetched) === 1 ? $fetched[0] : $fetched;
            }
        }
        
        return $executed;
    }
    
    protected function prepare($query)
    {
        return $this->pdo->prepare($query);
    }
    
    protected function lastInsert()
    {
        return $this->pdo->lastInsertId();
    }

    private function getPDOParam($value)
    {
        return is_integer($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
    }

    private function getQueryInsert($data)
    {
        $query = "INSERT INTO {$this->table} ";
        $columns_array  = [];
        $pointers_array = [];
        foreach($data as $column => $value)
        {
            array_push($columns_array, $column);
            array_push($pointers_array, '?');
        }
        $columns  = implode(',', $columns_array);
        $pointers = implode(',', $pointers_array);
        $query .= "({$columns}) VALUES ({$pointers})";
        return $query;
    }

    private function getQueryUpdate($data)
    {
        $query = "UPDATE {$this->table} SET ";
        $setters = [];
        foreach($data as $column => $value)
        {
            array_push($setters, $column.' = ?');
        }
        $query .= implode(', ', $setters);
        return $query;
    }

    private function getWhereInPositions(array $values_array)
    {
        $values_positions = str_repeat("?,", count($values_array));
        $values = trim($values_positions, ',');
        return $values;
    }
    
    private function hasTimestamps()
    {
        return isset($this->timestamps) && $this->timestamps;
    }
}
