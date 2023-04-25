<?php

use Bookly\Providers\DB;
use Bookly\Providers\TwilioSMSManager;

// if (preg_match("/\/lotus\/admin\/rest-http\/(.*)/", $_SERVER['REQUEST_URI'], $matches)) {
require_once __DIR__ . "/../../load-env.php";
require_once __DIR__ . "/vendor/autoload.php";

$messenger = new TwilioSMSManager();

$data = $messenger->send();
foreach ($data as $dat) {
	file_put_contents(__DIR__ . '/sending.txt', json_encode($dat), FILE_APPEND);
}

print(json_encode($data));


// 	return exit();
// }
