<?php

use Phalcon\Loader;

$loader = new Phalcon\Loader();
$loader->registerNamespaces(
	[
		'App' => "../app/",
	]
)->register();