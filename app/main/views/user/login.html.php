<?php
/**
 * @var App\Main\Forms\LoginForm $form
 */
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">

		<form class="form-horizontal" method="post">
			<div class="form-group">
				<label for="login" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<?= $this->tag->renderFromElement($form, "email"); ?>
					<?php foreach ($form->getMessagesFor("email") as $message) : ?>
						<?= $message ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="form-group"><label for="password" class="col-sm-2 control-label">Password</label>

				<div class="col-sm-10">
					<?= $this->tag->renderFromElement($form, "password"); ?>
					<?php foreach ($form->getMessagesFor("password") as $message) : ?>
						<?= $message ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Login</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $this->getContent(); ?>