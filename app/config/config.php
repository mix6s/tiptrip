<?php
use Phalcon\Logger;
return [
	'database' => [
		'name' => '',
		'host' => '',
		'username' => '',
		'password' => '',
		'port' => '',
		'adapter' => 'pgsql',
	],
	'application.main' => [
		'viewsDir' => "../app/Main/Views"
	],
	'logger' => [
		'path'     => APP_PATH . '../logs/',
		'logLevel' => Logger::DEBUG,
		'filename' => 'application.log',
	]
];