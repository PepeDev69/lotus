<?php

require_once __DIR__ . '/wp-content/bookly/src/Env.php';

(new Env())->createFrom(dirname(__FILE__))->load();

// if (preg_match("/\/lotus\/admin\/bookly\/(.*)/", $_SERVER['REQUEST_URI'], $matches)) {
// 	require(__DIR__ . "/wp-content/bookly-admin/public/vite-loader.php");
// 	exit(0);
// }
