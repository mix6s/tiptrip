<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 */
$di = $this->getDI();
?>
<div class="modal fade" id="popup_registration" tabindex="-1" role="dialog">
	<div class="modal-dialog js-modal-page" data-page="registration">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Регистрация</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal" method="post" action="<?= $di->url->get(['for' => 'registration'])?>">
							<div class="form-group">
								<label for="login" class="col-sm-3 control-label">Email</label>
								<div class="col-sm-7">
									<?= $di->tag->renderFromElement($di->forms->get('registration'), "email"); ?>
									<?php foreach ($di->forms->get('registration')->getMessagesFor("email") as $message) : ?>
										<?= $message ?>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-3 control-label">Пароль</label>
								<div class="col-sm-7">
									<?= $di->tag->renderFromElement($di->forms->get('registration'), "password"); ?>
									<?php foreach ($di->forms->get('registration')->getMessagesFor("password") as $message) : ?>
										<?= $message ?>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default pull-right">Создать аккаунт</button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<small class="pull-right">или <a href="#" class="js-change-page" data-page="login">Войдите</a></small>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-dialog js-modal-page hide" data-page="login">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Авторизация</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal" method="post" action="<?= $di->url->get(['for' => 'login'])?>">
							<div class="form-group">
								<label for="login" class="col-sm-3 control-label">Email</label>
								<div class="col-sm-7">
									<?= $di->tag->renderFromElement($di->forms->get('login'), "email"); ?>
									<?php foreach ($di->forms->get('login')->getMessagesFor("email") as $message) : ?>
										<?= $message ?>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-3 control-label">Пароль</label>
								<div class="col-sm-7">
									<?= $di->tag->renderFromElement($di->forms->get('login'), "password"); ?>
									<?php foreach ($di->forms->get('login')->getMessagesFor("password") as $message) : ?>
										<?= $message ?>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default pull-right">Войти</button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<small class="pull-right">У вас нет аккаунта? <a href="#" class="js-change-page" data-page="registration">Создать аккаунт</a></small>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		var $popup = $('#popup_registration');
		function changeModalPage(page) {
			$popup.find('.js-modal-page').each(function () {
				if ($(this).data('page') == page) {
					$(this).removeClass('hide');
				} else {
					$(this).addClass('hide');
				}
			})
		}
		$popup
			.on('show.bs.modal', function (e) {
				changeModalPage($(e.relatedTarget).data('page'));
			})
			.on('click', '.js-change-page', function () {
				changeModalPage($(this).data('page'));
				return false;
			})
		;
	});
</script>