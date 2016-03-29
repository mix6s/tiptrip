<?php

use App\Main\Components\DI;
use Phalcon\Config;
use Phalcon\Mvc\Application;

$env = 'prod';
if (isset($_SERVER['SERVER_DEV_TYPE'])) {
	$env = $_SERVER['SERVER_DEV_TYPE'];
} else {
	if ($_SERVER['SERVER_NAME'] == '127.0.0.1'
		|| strpos($_SERVER['SERVER_NAME'], 'localhost') !== false
		|| strpos($_SERVER['SERVER_NAME'], '192.168') !== false) {
		$env = 'dev';
	}
}

$env = 'dev';
$config = new Config(require('../app/config/config.php'));
$config->merge(new Config(require(APP_PATH . 'config/' . $env . '.php')));
$config->merge(new Config(['env' => $env]));
require APP_PATH . 'config/loader.php';
$di = new DI();
$di->set('config', $config);
require APP_PATH . 'config/services.php';
$application = new Application($di);
echo $application->handle()->getContent();