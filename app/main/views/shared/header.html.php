<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 */
$di = $this->getDI();
?>
<header class="header-main <?= $this->router->getMatchedRoute()->getName() == 'index' ? 'header-welcome' : ''?>">
	<div class="row vertical-center">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
			<a class="header-logo" href="/"><img src="images/logo.png" alt=""/></a>
		</div>
		<div class="mobile-header-icons col-sm-6 col-xs-6 hidden-lg hidden-md">
			<i class="icon-exit"></i>
			<i id="mobile-icon-menu" class="icon-gamburger"></i>
		</div>
		<nav class="<?= ($di->securityManager->isCurrentUserLogin()) ? 'col-lg-6 col-md-6'  : 'col-lg-9 col-md-9'?>hidden-sm hidden-xs">
			<ul class="header-navigation">
				<li><a href="">О проекте</a></li>
				<li><a href="<?= $di->url->get(['for' => 'trips']) ?>">Туры</a></li>
				<li><a href="">Помощь</a></li>
				<?php if (!$di->securityManager->isCurrentUserLogin()): ?>
					<li><?= $di->tag->popupLink('Регистрация', 'registration', ['data-page' => 'registration']) ?></li>
					<li><?= $di->tag->popupLink('Вход', 'registration', ['data-page' => 'login']) ?></li>
				<?php endif; ?>
			</ul>
		</nav>
		<?php if ($di->securityManager->isCurrentUserLogin()): ?>
		<div class="col-lg-3 col-md-3 header-profile hidden-sm hidden-xs">
			<div class="header-profile-avatar">
				<img src="images/delete/avatar.jpg" alt="">
			</div>
			<div class="header-profile-account">
				<div class="header-profile-sum">Баланс: <span class="highlight-green"><?= $di->tag->rub($di->securityManager->getCurrentUser()->account->amount)?></i></span></div>
				<a href="">Пополнить счет</a>
			</div>
			<div class="header-profile-menu">
				<ul>
					<li><i class="icon-paper"></i> <a href="">Мои туры</a></li>
					<li><i class="icon-history"></i> <a href="">История операций</a></li>
					<li><i class="icon-setting"></i> <a href="">Настройки</a></li>
					<li><i class="icon-exit"></i> <a href="<?= $di->url->get(['for' => 'logout']) ?>">Выход</a></li>
				</ul>
			</div>
		</div>
		<?php endif; ?>
	</div>
</header>