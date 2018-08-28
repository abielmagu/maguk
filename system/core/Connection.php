<?php namespace System\Core;

use \PDO;
use \PDOException;

class Connection
{
	private static $instance = null;
	public $fetch_types = [
		'num'   => PDO::FETCH_NUM,
		'assoc' => PDO::FETCH_ASSOC,
		'obj'   => PDO::FETCH_OBJ
	];
	public $connection;

    private function __construct()
    {
		try
		{
			$server = Config::get('database');
			$dsn  = $server['driver'].': host='.$server['host'].'; dbname='.$server['name'].';';
			$user = $server['user'];
			$pass = $server['pass'];

			// $opt = [
			// 	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			// 	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			// 	PDO::ATTR_EMULATE_PREPARES   => false,
			// ];
			
			$this->connection = new PDO($dsn,$user,$pass);
		}
		catch(PDOException $e)
		{
			Exception::stop($e->getMessage());
		}
	}
    
	static public function getInstance()
	{
		if( is_null(self::$instance) )
		{
			self::$instance = new Connection();
		}
		return self::$instance->connection;
	}

	public function __clone(){}
	public function __sleep(){}
	public function __wakeup(){}
}

// $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE); // there are other ways to set attributes. this is one

// $connections = Session::getTemp('connections') ?: 1;
// Session::setTemp('connections', $connections++);
