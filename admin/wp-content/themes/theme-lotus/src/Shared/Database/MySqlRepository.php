<?php

namespace Lotus\Shared\Database;

interface MySqlRepository 
{
    public function prepare(string $stmt, array $bindings = []);

    public function raw(string $stmt, array $bindings = []);

    public function select(string $stmt, array $bindings = []);

    public function selectOne(string $stmt, array $bindings = []);

    public function insert(string $stmt, array $bindings = []);

    public function update(string $stmt, array $bindings = []);

	public function delete(string $stmt, array $bindings = []);

}