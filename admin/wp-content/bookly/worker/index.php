#!/usr/bin/php
<?php

// final class Queue
// {
// 	/**
// 	 * The Queued jobs
// 	 * 
// 	 * @var array 
// 	 */
// 	private $queue;

// 	public function __construct($queue, PDO $pdo)
// 	{
// 		$this->queue = $queue;
// 		$this->db    = $pdo;
// 	}
// }


file_put_contents(__DIR__ . '/test.text', "[" . date("Y-m-d H:m:s") . "] Test" . PHP_EOL, FILE_APPEND);
