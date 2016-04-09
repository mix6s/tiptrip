<?php
use App\Main\Components\DI;
use App\Main\Forms\TripFilterForm;
use App\Main\Models\Trip;
/**
 * @var TripFilterForm $form
 * @var Trip[] $trips
 * @var DI $this
 */
?>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form class="form-horizontal" method="get">
				<div class="form-group">
					<label class="col-sm-2 control-label">direction</label>

					<div class="col-sm-10">
						<?= $this->tag->renderFromElement($form, "direction"); ?>
						<?php foreach ($form->getMessagesFor("direction") as $message) : ?>
							<?= $message ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">status</label>
					<div class="col-sm-10">
						<?= $this->tag->renderFromElement($form, "status"); ?>
						<?php foreach ($form->getMessagesFor("status") as $message) : ?>
							<?= $message ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">price</label>
					<div class="col-sm-5">
						<?= $this->tag->renderFromElement($form, "priceFrom"); ?>
						<?php foreach ($form->getMessagesFor("priceFrom") as $message) : ?>
							<?= $message ?>
						<?php endforeach; ?>
					</div>
					<div class="col-sm-5">
						<?= $this->tag->renderFromElement($form, "priceTo"); ?>
						<?php foreach ($form->getMessagesFor("priceTo") as $message) : ?>
							<?= $message ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox" for="onlyFav">
							<label>
								<?= $this->tag->renderFromElement($form, "onlyFav", ['class' => '']); ?> Only fav
							</label>
						</div>
						<?php foreach ($form->getMessagesFor("onlyFav") as $message) : ?>
							<?= $message ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<section class="tours-wrapper tours-preview section container">
		<div class="section-title">Список туров:</div>
		<div class="row">
			<?php foreach ($trips AS $trip): ?>
				<?= $this->partial("shared/trip_card", ['trip' => $trip]); ?>
			<?php endforeach; ?>
		</div>
		<div class="text-center tours-all-link">
			<a href="<?= $this->url->get(['for' => 'trips'])?>">Смотреть все туры</a>
		</div>
	</section>
<?= $this->getContent(); ?>