<?php

namespace Bookly\Providers;

/**
 * @method static \Lotus\Shared\Database\TableCollection tables()
 * @method static \Lotus\Shared\Database\QueryBuilder table(string $table)
 * @method static \Lotus\Shared\Database\MySqlConnection raw($value)
 * @method static array select(string $query, array $bindings = [])
 * @method static bool insert(string $query, array $bindings = [])
 * @method static int delete(string $query, array $bindings = [])
 * @method static int update(string $query, array $bindings = [])
 * @method static mixed selectOne(string $query, array $bindings = [])
 * @method static \Lotus\Shared\Database\QueryBuilder queryBuilder(string $query)
 * @see \Lotus\Shared\Database\MySqlConnection
 */

final class DB
{
	/**
	 * The Mysql instance Facade
	 * 
	 * @var MySqlConnection|null
	 */
	private static $instance;

	/**
	 * Call methods dynamically as static 
	 * 
	 * @return mixed
	 */
	public static function __callStatic($method, $args)
	{
		$config = [
			'host'      => env('DB_HOST'),
			'database'  => env('DB_NAME'),
			'username'  => env('DB_USER'),
			'password'  => env('DB_PASSWORD'),
			'charset'   => env('DB_CHARSET'),
			'db_prefix' => env('DB_PREFIX'),
			'collation' => 'utf8_unicode_ci',
		];

		if (is_null(static::$instance)) {
			static::$instance = new MySqlConnection($config);
		}
		return static::$instance->$method(...$args);
	}
}
