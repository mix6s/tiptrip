<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 */
$di = $this->getDI();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="icon/favicon.ico">
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/circle.css">
</head>
<body>

<!--[if lt IE 8]>
<div class="browse-happy-wrapper">
	<p>Вы используете <strong>устаревший</strong> браузер. Пожалуйста, <a href="http://browsehappy.com/">обновите ваш браузер</a>, чтобы сайт отображался корректно.</p>
</div>
<![endif]-->
<div id="content-overlay" class="content-overlay">
	<i id="mobile-navigation-close" class="icon-close"></i>
</div>
<?= $this->partial("shared/mobile/navigation"); ?>
<div class="container">
	<?= $this->partial("shared/header"); ?>
</div>
<?php if ($this->router->getMatchedRoute()->getName() == 'index'): ?>
	<?= $this->partial("shared/swiper_welcome"); ?>
<?php endif; ?>
<main class="content-main">
	<?= $this->flash->output(); ?>
	<?= $this->getContent(); ?>
</main>
<?= $this->partial("shared/footer"); ?>
<script type="text/javascript" src="/js/jquery-2.2.2.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/swiper.min.js"></script>
<script type="text/javascript" src="/js/circle-progress.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<?= $di->popupManager->output() ?>
</body>
</html>