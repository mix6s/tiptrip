<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Models\Trip $trip
 * @var App\Main\Components\DI $di
 */
$di = $this->getDI();
?>
<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
	<div class="tour-item col-bg">
		<div class="tour-item-preview" style="background: url('images/delete/tour_preview.jpg') 50% 50% no-repeat;">
			<div class="tour-sum-wrapper">
				<div class="tour-sum-label">Стоимость тура:</div>
				<span class="highlight-text"><?= $di->tag->rub($trip->price) ?></span>
			</div>
			<div class="tour-name-wrapper">
				<div class="tour-name"><?= $trip->title ?></div>
				<div class="tour-hotel">
					<p><?= $trip->hotelTitle ?></p>
					<a href="<?= $di->url->get(['for' => 'trip', 'id' => $trip->id])?>" class="highlight-text">Подробнее</a>
				</div>
			</div>
		</div>
		<div class="tour-item-description">
			<div class="tour-description-content">
				<div class="tour-description-left">
					<div class="tour-people-info">
						<div>
							<i class="icon-user"></i> <span>2</span>
						</div>
						<div>
							<i class="icon-calendar"></i> <span>14</span>
						</div>
					</div>
				</div>
				<div class="tour-description-right">
					<div class="tour-people-info">
						<span>1 : <?= $trip->multiplicity ?></span>
					</div>
				</div>
			</div>
			<div class="tour-description-content">
				<div class="tour-description-left">
					<div class="tour-number-info">
						<div class="tour-label">Время до окончания:</div>
						<span><?= $di->tag->timeCounter($trip->endDt) ?></span>
					</div>
				</div>
				<div class="tour-description-right">
					<div class="tour-number-info">
						<div>Стоимость шанса:</div>
						<span class="highlight-sum"><?= $di->tag->rub($trip->ticketPrice) ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success"><i class="icon-cart"></i> Купить шанс</button>
		</div>
	</div>
</div>

