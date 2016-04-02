<?php

use Phalcon\Loader;

$loader = new Phalcon\Loader();
$loader->registerNamespaces(
	[
		'App' => APP_PATH,
	]
)->register();