<?php
use Phalcon\Logger;

require 'constants.php';

return [
	'database' => [
		'name' => '',
		'host' => '',
		'username' => '',
		'password' => '',
		'port' => '',
		'adapter' => 'pgsql',
	],
	'cache' => [
		'host' => '127.0.0.1',
		'port' => 11211
	],
	'application.main' => [
		'viewsDir' => "../app/Main/Views"
	],
	'logger' => [
		'path'     => APP_PATH . '../runtime/',
		'filename' => 'application.log',
	]
];