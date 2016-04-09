<?php

use App\Main\Components\Acl;
use App\Main\Components\PopupManager;
use App\Main\Components\SecurityManager;
use App\Main\Components\TripManager;
use App\Main\Helpers\BootstrapTag;
use App\Main\Forms;
use Phalcon\Cache\Backend\Memcache AS Cache;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Flash\Session AS Flash;
use Phalcon\Forms\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Postgresql as DbAdapter;
use Phalcon\Logger\Adapter\File as Logger;
use Phalcon\Logger\Formatter\Line as Formatter;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Model\Metadata\Memcache AS MetadataAdapter;

/** @var Config $config */

$di->setShared('securityManager', function () {
	return new SecurityManager();
});

$di->setShared('tripManager', function () {
	return new TripManager();
});

$di->setShared('forms', function () {
	$manager = new Manager();
	$forms = [
		'registration' => Forms\RegistrationForm::class,
		'login' => Forms\LoginForm::class,
		'trip_filter' => Forms\TripFilterForm::class,
		'password_restore' => Forms\TripFilterForm::class,
	];
	foreach ($forms AS $name => $class) {
		$manager->set($name, new $class());
	}
	return $manager;
});

$di->setShared('popupManager', function () {
	return new PopupManager();
});

$di->setShared('acl', function () {
	return new Acl();
});

$di->setShared('tag', function () {
	return new BootstrapTag();
});

$di->setShared('cache', function () use ($config) {
	return new Cache(new Data(), [
		'prefix' => 'main_',
		'host' => $config->cache->host,
		'port' => $config->cache->port,
	]);
});

$di->setShared('modelsMetadata', function () use ($config) {
	$metaData = new MetadataAdapter(
		[
			'prefix' => 'metadata_',
			'lifetime' => 86400,
			'host' => $config->cache->host,
			'port' => $config->cache->port,
			'persistent' => false
		]
	);

	return $metaData;
});

$di->set(
	'dispatcher',
	function () use ($di) {
		$eventsManager = $di->getShared('eventsManager');
		$eventsManager->attach(
			'dispatch:beforeException',
			function($event, $dispatcher, $exception) {
				switch ($exception->getCode()) {
					case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
					case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
						$dispatcher->forward(
							[
								'controller' => 'error',
								'action' => 'notFound',
							]
						);
						return false;
						break;
					default:
						$dispatcher->forward(
							[
								'controller' => 'error',
								'action' => 'uncaughtException',
								'params' => [$exception],
							]
						);
						return false;
						break;
				}
			}
		);
		$dispatcher = new Dispatcher();
		$dispatcher->setEventsManager($eventsManager);
		$dispatcher->setDefaultNamespace('App\Main\Controllers');
		return $dispatcher;
	}
);

$di->set('db', function () use ($config, $di) {
	/** @var \Phalcon\Events\Manager $eventsManager */
	$eventsManager = $di->getShared('eventsManager');
	/** @var \Phalcon\Logger\AdapterInterface $logger */
	$logger = $di->getShared('logger');

	$eventsManager->attach('db', function ($event, $connection) use ($logger) {
		/** @var \Phalcon\Db\AdapterInterface $connection */
		if ($event->getType() == 'beforeQuery') {
			$logger->debug($connection->getSQLStatement());
		}
	});

	$connection = new DbAdapter(
		[
			"host"     => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"port" => $config->database->port,
			"dbname"   => $config->database->name
		]
	);

	$connection->setEventsManager($eventsManager);
	return $connection;
});

$di->set('flash', function () {
	$flash = new Flash(
		[
			'error'   => 'alert alert-danger',
			'success' => 'alert alert-success',
			'notice'  => 'alert alert-info',
			'warning' => 'alert alert-warning'
		]
	);

	return $flash;
});

$di->setShared('session', function () {
	$session = new Session();
	$session->start();
	return $session;
});

$di->set(
	'router',
	function () use ($config){
		$router = new Router();
		$router->add("/", "Index::index")->setName('index');
		$router->add("/clear_cache", "Index::clearCache");
		$router->add("/login", "User::login")->setName('login');
		$router->add("/registration", "User::registration")->setName('registration');
		$router->add("/logout", "User::logout")->setName('logout');;
		$router->add("/profile", "User::profile")->setName('profile');
		$router->add("/forgot", "User::passwordRestore");
		$router->add("/trip", "Trip::list")->setName('trips');
		$router->add("/trip/{id:[0-9]+}", "Trip::index")->setName('trip');
		$router->add("/attempt", "Attempt::index");
		return $router;
	}
);

$di->set(
	'view',
	function () use ($config){
		$view = new View();
		$view->registerEngines([".html.php" => 'Phalcon\Mvc\View\Engine\Php']);
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

$di->set(
	'logger',
	function () use ($config) {
		$filename = trim($config->get('logger')->filename, '\\/');
		$path = rtrim($config->get('logger')->path, '\\/') . DIRECTORY_SEPARATOR;
		$formatter = new Formatter('%date% main.%type%: %message%', '[Y-m-d H:i:s]');
		$logger = new Logger($path . $filename);
		$logger->setFormatter($formatter);
		$logLevel = $config->get('logger')->logLevel;
		if (null !== $logLevel) {
			$logger->setLogLevel($logLevel);
		}
		return $logger;
	}
);