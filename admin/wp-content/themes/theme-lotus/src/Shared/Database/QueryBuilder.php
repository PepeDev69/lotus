<?php

namespace Lotus\Shared\Database;


final class QueryBuilder
{
	/**
	 * @var \Lotus\Shared\Database\MySqlConnection
	 */
	private $sql;

	/**
	 * @var string
	 */
	private $model;

	/**
	 * Partial sql statement
	 * 
	 * @var string
	 */
	private $stmt;

	/**
	 * Where clause statement
	 * 
	 * @var string
	 */
	private $where;

	/**
	 * Order clause statement
	 * 
	 * @var string
	 */
	private $order;

	/**
	 * Chached statement
	 * 
	 * @var string
	 */
	private $cachedStmt;


	private $bindings = [];

	private $selectables = '*';

	public function __construct(MySqlConnection $conn, string $model)
	{
		$this->sql   = $conn;
		$this->model = $model;
		$this->setup();
	}

	public function makeQuery(string $query)
	{
		$this->cachedStmt = $query;
		return $this;
	}

	private function setup()
	{
		$this->stmt = "SELECT {$this->selectables} FROM {$this->model}";
	}

	public function merge(string $query = '', $bindigs = [], $only = false)
	{
		$this->cachedStmt = "{$this->cachedStmt} {$query}";
		return $only === true
			? $this->sql->selectOne($this->cachedStmt, $bindigs)
			: $this->sql->select($this->cachedStmt, $bindigs);
	}

	public function select($args = '*')
	{
		$partial = is_array($args) ? $args : func_get_args();
		// $this->selectables = join(',', array_map(function ($tap) {
		// 	return "`" . $tap . "`";
		// }, $partial));
		$this->selectables = join(',', $partial);

		$this->setup();
		return $this;
	}

	public function where($type, $operator, $value = null)
	{
		list($_operator, $_value) = $this->whereBuilder($type, $operator, $value);
		$this->where = "WHERE {$type} {$_operator} ?";
		array_push($this->bindings, $_value);

		return $this;
	}

	public function andWhere($type, $operator, $value = null)
	{
		list($_operator, $_value) = $this->whereBuilder($type, $operator, $value);
		if (!empty($this->where)) {
			$this->where .= " AND {$type} {$_operator} ?";
			array_push($this->bindings, $_value);

			return $this;
		}
	}

	public function orderBy($col, $type)
	{
		$this->order = "ORDER BY $col $type";
		return $this;
	}

	private function whereBuilder($type, $operator, $value)
	{
		$operator_def  = is_null($value) ? '=' : $operator;
		$value_def     = $value ?: $operator;
		return [$operator_def, $value_def];
	}

	public function get($count = 0)
	{
		if ($count === 1) {
			return $this->first();
		}
		$this->stmt = "{$this->stmt} {$this->where}";
		return $this->sql->select($this->stmt, $this->bind_params());
	}

	public function first()
	{
		$this->stmt = $this->stmt() . " {$this->where} LIMIT 1";
		return $this->sql->selectOne($this->stmt, $this->bind_params());
	}

	public function delete()
	{
		$this->stmt = "DELETE FROM {$this->model} {$this->where}";
		return $this->stmt;
		// return $this->sql->delete($this->stmt, $this->bind_params());
	}

	public function bind_params()
	{
		return $this->bindings;
	}

	private function make()
	{
		return "{$this->stmt}";
	}

	private function stmt()
	{
		return $this->stmt;
	}
}
