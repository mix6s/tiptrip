<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Postgresql as DbAdapter;
use Phalcon\Logger\Adapter\File as Logger;
use Phalcon\Logger\Formatter\Line as Formatter;

/** @var Config $config */

$di->set(
	'dispatcher',
	function () {
		$dispatcher = new Dispatcher();
		$dispatcher->setDefaultNamespace('App\Main\Controllers');
		return $dispatcher;
	}
);

$di->set('db', function () use ($config) {
	return new DbAdapter(
		[
			"host"     => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"port" => $config->database->port,
			"dbname"   => $config->database->name
		]
	);
});

$di->set(
	'view',
	function () use ($config){
		$view = new View();
		$view->setViewsDir($config->get('application.main')->viewsDir);
		return $view;
	}
);

$di->set(
	'url',
	function () {
		$url = new Url();
		$url->setBaseUri('/');
		return $url;
	}
);

$di->set('logger', function () use ($config) {
	$filename = trim($config->get('logger')->filename, '\\/');
	$path     = rtrim($config->get('logger')->path, '\\/') . DIRECTORY_SEPARATOR;

	$formatter = new Formatter('%date% main.%type%: %message%', '[Y-m-d H:i:s]');
	$logger    = new Logger($path . $filename);
	$logger->setFormatter($formatter);
	$logger->setLogLevel($config->get('logger')->logLevel);
	return $logger;
});