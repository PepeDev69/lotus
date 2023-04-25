<?php

namespace Bookly\Providers;

use PDO;

class MySqlConnection
{
	/**
	 * PDO collection of initial atributes
	 * @var array
	 */
	protected $options = [
		PDO::ATTR_CASE => PDO::CASE_NATURAL,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
		PDO::ATTR_STRINGIFY_FETCHES => false,
		PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
	];

	/**
	 * Driver of PDO
	 * @var array
	 */
	private $driver;

	/**
	 * The PDO instance
	 * @var PDO
	 */
	private $db;

	/**
	 * Connection times count
	 * @var int
	 */
	private $conection = 0;

	/**
	 * Partial PDO statement
	 * @var \PDOStatement|false
	 */
	protected $stmt;

	/**
	 * Tables collection
	 * @var \TableCollection
	 */
	private $tables;

	/**
	 * Tables prefix
	 * @var string
	 */
	private $prefix;

	/**
	 * Inject database array config and init database instance
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->driver = $config['driver'] ?? 'mysql';
		$this->prefix = $config['db_prefix'];
		$this->setConnection($config);
		$this->set_tables();
	}

	/**
	 * Create database connection
	 * @param array $config
	 */
	final private function setConnection(array $config)
	{
		$config = (object) $config;

		$DSN = "{$this->driver}:host={$config->host};dbname={$config->database};charset={$config->charset}";
		array_push($this->options, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$config->charset}' COLLATE '{$config->collation}'"]);

		try {
			if (empty($this->db)) {
				$this->db = new PDO($DSN, $config->username, $config->password, $this->options);
				$this->conection++;
			}
		} catch (\PDOException $error) {
			throw $error;
		}
	}

	/**
	 * Prepare queries for prevent
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return \PDOStatement|false
	 */
	public function prepare(string $stmt, array $bindings = [])
	{
		$statement = $this->db->prepare($stmt);

		if (!empty($bindings)) {
			foreach ($bindings as $key => $value) {
				$PARAM_TYPE  = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
				$PARAM_INDEX = is_int($key) ? $key + 1 : $key;
				$statement->bindValue($PARAM_INDEX, $value, $PARAM_TYPE);
			}
		}

		return $statement;
	}

	/**
	 * Make raw sql queries
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return mixed
	 */
	public function raw(string $stmt, array $bindings = [])
	{
		return $this->db->query($stmt)->fetchAll();
	}

	/**
	 * Select all rows with prepare statement
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return mixed[]
	 */
	public function select(string $stmt, array $bindings = [])
	{
		$statement = $this->prepare($stmt, $bindings);
		if ($statement->execute()) {
			return $statement->fetchAll();
		}
	}

	/**
	 * Select one row with prepare statement
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return mixed
	 */
	public function selectOne(string $stmt, array $bindings = [])
	{
		$statement = $this->prepare($stmt, $bindings);
		if ($statement->execute()) {
			return $statement->fetch();
		}
	}

	/**
	 * Insert data to row with prepare statement
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return string|false
	 */
	public function insert(string $stmt, array $bindings = [])
	{
		$statement = $this->prepare($stmt);
		if ($statement->execute($bindings)) {
			return $this->db->lastInsertId();
		}
		return false;
	}

	/**
	 * Update data to row with prepare statement
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return bool
	 */
	public function update(string $stmt, array $bindings = [])
	{
		$statement = $this->prepare($stmt);
		if ($statement->execute($bindings)) {
			return true;
		}
		return false;
	}

	/**
	 * Delete data to row with prepare statement
	 * 
	 * @param string $stmt
	 * @param array|null $bindings
	 * 
	 * @return bool
	 */
	public function delete(string $stmt, array $bindings = [])
	{
		$statement = $this->prepare($stmt, $bindings);
		if ($statement->execute()) {
			return true;
		}
		return false;
	}

	public function insertId()
	{
		return $this->db->lastInsertId();
	}

	/**
	 * Return the connections made during the process
	 * 
	 * @return int
	 */
	public function connectionTimes()
	{
		return $this->conection;
	}

	public function beginTransaction()
	{
		$this->sql->beginTransaction();
	}

	public function commit()
	{
		$this->sql->commit();
	}

	public function rollBack()
	{
		$this->sql->rollBack();
	}

	/**
	 * Fill tables with named tables of wordpress
	 * 
	 * @return void
	 */
	private function set_tables()
	{
		$this->tables = (object) [
			"prefix"         => "{$this->prefix}",
			"posts"          => "{$this->prefix}posts",
			"postmeta"       => "{$this->prefix}postmeta",
			"terms"          => "{$this->prefix}terms",
			"term_taxonomy"  => "{$this->prefix}term_taxonomy",
			"term_relations" => "{$this->prefix}term_relationships",
			"termmeta"       => "{$this->prefix}termmeta",
			"options"        => "{$this->prefix}options",
			"users"          => "{$this->prefix}users",
			"usermeta"       => "{$this->prefix}usermeta",
			"comments"       => "{$this->prefix}comments",
			"commentmeta"    => "{$this->prefix}commentmeta",
			"links"          => "{$this->prefix}links",
			"schedule"       => "mv_schedule",
			"doctor"		 => "mv_doctor",
			"customer"		 => "mv_customer"
		];
	}

	/**
	 * Retrun tables with named tables of wordpress
	 * 
	 * @return \TablesCollection
	 */
	public function tables()
	{
		return $this->tables;
	}
}
