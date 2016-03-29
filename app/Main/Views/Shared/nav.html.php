<?php
/** @var App\Main\Components\DI $di */
$di = $this->getDi();
?>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
					data-target="#bs-example-navbar-collapse-3" aria-expanded="false"><span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
			<a class="navbar-brand" href="#"><?= $di->securityManager->isCurrentUserLogin() ? $di->securityManager->getCurrentUser()->nickname : 'guest'?></a></div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">

			<?php if ($di->securityManager->isCurrentUserLogin()) : ?>
				<a class="btn btn-default navbar-btn" href="/logout">Logout</a>
				<a class="btn btn-default navbar-btn" href="/profile">Profile</a>
			<?php else: ?>
				<a class="btn btn-default navbar-btn" href="/login">Sign in</a>
				<a class="btn btn-default navbar-btn" href="/registration">Registration</a>
				<a class="btn btn-default navbar-btn" href="/forgot">Restore password</a>
			<?php endif; ?>
			<a class="btn btn-default navbar-btn" href="/trip">Trip list</a>
		</div>
	</div>
</nav>