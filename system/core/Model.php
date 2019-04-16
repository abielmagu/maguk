<?php namespace System\Core;

use \PDO;
use \PDOException;

abstract class Model
{
    protected $pdo;
    protected $query;
    protected $character_set;
    protected $collation_ci;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
        $this->character_set = 'utf8mb4_bin';
        $this->collation_ci = 'utf8mb4_general_ci';
    }
 
    public function getNameTable()
    {
        if( isset($this->table) )
            return $this->table;
            
        return false;
    }
    
    public function all($order = 'DESC')
    {
        $this->query = "SELECT * FROM {$this->table} ORDER BY id {$order}";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function availables($order = 'DESC')
    {
        $this->query = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY id {$order}";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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

    public function where($column, $operator, $value, $sensitive = true)
    {
        $PDOParam = $this->getPDOParam($value);
        $this->query = $sensitive 
                     ? "SELECT * FROM {$this->table} WHERE {$column} {$operator} :value"
                     : "SELECT * FROM {$this->table} WHERE {$column} COLLATE {$this->collation_ci} {$operator} :value"; 
                                                                    // _cs = Case Sensitive & _ci = Case insensitive
                
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':value', $value, $PDOParam);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function whereUpLow($column, $operator, $value, $upper = true)
    {
        $PDOParam = $this->getPDOParam($value);
        $this->query = $upper 
                     ? "SELECT * FROM {$this->table} WHERE UPPER({$column}) {$operator} :value"
                     : "SELECT * FROM {$this->table} WHERE LOWER({$column}) {$operator} :value"; 
        $stmt = $this->pdo->prepare( $this->query );
        $value_uplow = $upper ? strtoupper($value) : strtolower($value);
        $stmt->bindValue(':value', $value_uplow, $PDOParam);
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

    public function whereNotIn($column, array $values)
    {
        $positions = $this->getWhereInPositions($values);
        $this->query = "SELECT * FROM {$this->table} WHERE {$column} NOT IN ({$positions})";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute( $values );
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function isNull($column, $not = false)
    {
        $this->query = "SELECT * FROM {$this->table} WHERE {$column} IS ";
        $this->query .= $not ? "NOT NULL" : "NULL";
        $this->query .= " ORDER BY id DESC";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute();
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
            $data = array_merge($data, ['created_at' => DATETIME_NOW, 'updated_at' => DATETIME_NOW]);

        $this->query = $this->getQueryInsert($data);
        $stmt = $this->pdo->prepare( $this->query );
        if( $stmt->execute( array_values($data) ) )
            return $this->lastInsert();
        
        return false;
    }

    public function update(array $data, $where, $justone = true)
    {
        if( $this->hasTimestamps() )
            $data = array_merge($data, ['updated_at' => DATETIME_NOW]);
        
        $this->query = $this->getQueryUpdate($data);

        if( is_array($where) )
        {
            $line = null;
            foreach($where as $column => $value)
            {
                $line = is_null($line) ? " WHERE {$column}" : " AND {$column}";
                if( is_null($value) )
                {
                    $line .= ' IS NULL';
                }
                elseif( $value === '!null')
                {
                    $line .= ' IS NOT NULL';
                }
                elseif( strpos($value, '!') === 0 )
                {
                    $value = str_replace('!', '', $value);
                    $line .= " != '{$value}'";
                }
                else
                {
                    $line .= " = '{$value}'";
                }
                
                $this->query .= $line;
            }
        }
        else
        {
            $this->query .= " WHERE id = {$where}";
        }

        if( $justone )
            $this->query .= " LIMIT 1";

        $stmt = $this->pdo->prepare( $this->query );
        if( $stmt->execute( array_values($data) ) )
            return $stmt->rowCount();
        
        return false;
    }
    
    public function delete($id, $justone = true)
    {
        $this->query = "DELETE FROM {$this->table} WHERE id = :id";

        if( $justone )
            $this->query .= " LIMIT 1";

        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if( $stmt->execute() ) 
            return $stmt->rowCount();
        
        return false;
    }

    public function deleteSoft($id)
    {
        $this->query = "UPDATE {$this->table} 
                        SET deleted_at = :deleted 
                        WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->bindValue(':deleted', DATETIME_NOW);
        $stmt->bindValue(':id', $id);
        if( $stmt->execute() )
            return $stmt->rowCount();
        
        return false;
    }
    
    public function trash()
    {
        $this->query = "SELECT * FROM {$this->table} WHERE deleted_at IS NOT NULL";
        $stmt = $this->pdo->prepare( $this->query );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function unduplicated($action, array $data, array $find, array $except = null)
    {        
        $column = key($find);
        $found = call_user_func_array([$this,'find'], [$find[$column], $column]);
        $prop = is_array($except) ? key($except) : false;
        
        if( !is_object($found) || is_string($prop) && $found->$prop === $except[$prop] )
        {
           return call_user_func_array([$this,$action], $data);
        }
        return $found;
        
        // $data = [data, |id]
        // $find = [column => value] 
        // $except = [prop => value]
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
                return $fetched;
                // return count($fetched) === 1 ? $fetched[0] : $fetched;
            }
        }
        
        return $executed;
    }
    
    private function hasTimestamps()
    {
        return isset($this->timestamps) && $this->timestamps;
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
}
