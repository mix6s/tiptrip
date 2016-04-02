<?php

use Phalcon\Config;
use Phalcon\Config\Adapter\Yaml as ConfigYaml;

$env = 'dev';
$config = new Config(require(realpath('app') . '/config/config.php'));
$config->merge(new Config(require(APP_PATH . 'config/' . $env . '.php')));
$config->merge(new Config(['env' => $env]));

return [
	'paths' => [
		'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
		'seeds' => '%%PHINX_CONFIG_DIR%%/seeds',
	],
	'environments' =>
	[
		'default_migration_table' => 'phinxlog',
		'default_database' => 'development',
		'development' => [
			'name' => $config->get('database')['name'],
			'adapter' => $config->get('database')['adapter'],
			'host' => $config->get('database')['host'],
			'user' => $config->get('database')['username'],
			'pass' => $config->get('database')['password'],
			'port' => $config->get('database')['port'],
		]
	]
];