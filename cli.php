<?php

use App\Main\Components\CliDI;
use Phalcon\Config;
use Phalcon\Cli\Console;

$env = 'dev';
$config = new Config(require('app/config/config.php'));
$config->merge(new Config(require(APP_PATH . 'config/' . $env . '.php')));
$config->merge(new Config(['env' => $env]));
require APP_PATH . 'config/loader.php';
require APP_PATH . '../vendor/autoload.php';
$di = new CliDI();
$di->get('dispatcher')->setDefaultNamespace('App\Tasks');
$di->get('dispatcher')->setNamespaceName ('App\Tasks');
$di->set('config', $config);
require APP_PATH . 'config/services.php';
$application = new Console($di);
$arguments = [];
foreach ($argv as $k => $arg) {
	if ($k == 1) {
		$arguments['task'] = $arg;
	} elseif ($k == 2) {
		$arguments['action'] = $arg;
	} elseif ($k >= 3) {
		$arguments['params'][] = $arg;
	}
}

define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));
try {
	$application->handle($arguments);
} catch (\Phalcon\Exception $e) {
	echo $e->getMessage();
	exit(255);
}