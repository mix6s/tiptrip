<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Models\Trip $trip
 * @var App\Main\Components\DI $di
 */
use App\Main\Components\TripManager;

$di = $this->getDI();
if (!isset($style)) {
	$style = 'full';
}
?>
<div class="tour-item-wrapper <?= 'full' == $style ? 'col-lg-10 col-md-10 col-sm-12 col-xs-12' : 'col-lg-5 col-md-5 col-sm-6 col-xs-12'; ?>">
	<div class="tour-item col-bg">
		<div class="tour-item-preview" style="background: url('images/delete/tour_preview_big.jpg') 50% 50% no-repeat;">
			<div class="tour-item-header">
				<div class="tour-sum-wrapper">
					<div class="tour-sum-label">Стоимость тура:</div>
					<span class="highlight-yellow"><?= $di->tag->rub($trip->price) ?></span>
				</div>
				<div class="tour-social-icons">
					<i class="icon-share"></i>
					<div class="tour-likes">
						<i class="icon-like"></i><span>9</span>
					</div>
				</div>
			</div>
			<div class="tour-item-preview-description">
				<div class="tour-name-wrapper">
					<?php if ($trip->status == TripManager::STATUS_SOON) : ?>
						<span class="label label-info label-lg">Скоро</span>
					<?php endif; ?>
					<?php if ($trip->status == TripManager::STATUS_ENDED) : ?>
						<span class="label label-success label-lg">Завершен</span>
					<?php endif; ?>
					<div class="tour-name"><?= $trip->title ?></div>
					<div class="tour-hotel">
						<p><span class="highlight-yellow"><?= $trip->direction->title ?></span> — <?= $trip->hotelTitle ?></p>
					</div>
				</div>
				<?php if ('full' == $style) : ?>
					<?php if ($trip->status == TripManager::STATUS_ACTIVE) : ?>
						<button type="button" class="btn btn-sm btn-success hidden-sm hidden-xs">
							<i class="icon-cart"></i> Купить шанс за <span><?= $di->tag->rub($trip->ticketPrice) ?></span>
						</button>
					<?php endif; ?>
					<?php if (in_array($trip->status, [TripManager::STATUS_SOON, TripManager::STATUS_WINNER_SEARCH])) : ?>
						<a class="btn btn-sm btn-default hidden-sm hidden-xs" href="<?= $di->url->get(['for' => 'trip', 'id' => $trip->id])?>">Подробнее</a>
					<?php endif; ?>
					<?php if ($trip->status == TripManager::STATUS_ENDED) : ?>
						<button type="button" class="btn btn-sm btn-success hidden-sm hidden-xs">Узнать победителя!</button>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="tour-item-description">
			<div class="tour-description-content-left">
				<div class="tour-description-content">
					<div class="tour-description-left">
						<div class="tour-people-info">
							<div>
								<i class="icon-plane"></i> <span>24.05.2016</span>
							</div>
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
				<?php if ($trip->status == TripManager::STATUS_ACTIVE) : ?>
					<div class="tour-description-content">
						<div class="tour-description-left">
							<div class="tour-number-info">
								<div class="tour-label">Время до окончания:</div>
							</div>
						</div>
						<div class="tour-description-right">
							<div class="tour-number-info">
								<span><?= $di->tag->timeCounter($trip->endDt) ?></span>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($trip->status == TripManager::STATUS_SOON) : ?>
					<div class="tour-description-content">
						<div class="tour-description-left">
							<div class="tour-number-info">
								<div class="tour-label">Стоимость шанса:</div>
							</div>
						</div>
						<div class="tour-description-right">
							<div class="tour-number-info">
								<span class="highlight-green"><?= $di->tag->rub($trip->ticketPrice) ?></span>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php if ($trip->status == TripManager::STATUS_ACTIVE) : ?>
				<div class="tour-description-content-right tour-description-progressbar">
					<div>Прогрессбар синий</div>
					<div>Прогрессбар зеленый</div>
				</div>
			<?php endif; ?>
			<?php if ($trip->status == TripManager::STATUS_SOON) : ?>
				<div class="tour-description-content-right">
					<div class="tour-description-content">
						<div class="tour-description-left">
							<div class="tour-number-info">
								<div class="tour-label">Дата начала торгов:</div>
							</div>
						</div>
						<div class="tour-description-right">
							<div class="tour-number-info">
								<span><?= $trip->startDt->format('d.m.Y'); ?></span>
							</div>
						</div>
					</div>
					<div class="tour-description-content">
						<div class="tour-description-left">
							<div class="tour-number-info">
								<div class="tour-label">Окончание торгов:</div>
							</div>
						</div>
						<div class="tour-description-right">
							<div class="tour-number-info">
								<span><?= $trip->endDt->format('d.m.Y'); ?></span>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($trip->status == TripManager::STATUS_WINNER_SEARCH) : ?>
				<div class="tour-description-content-right">
					<div class="tour-description-content">
						<div class="tour-description-left">
							<div class="tour-number-info">
								<div class="tour-label">Статус тура:</div>
							</div>
						</div>
						<div class="tour-description-right">
							<div class="tour-people-info">
								<i class="icon-question"></i> <span>Поиск путешественника</span>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($trip->status == TripManager::STATUS_ENDED) : ?>
				<div class="tour-description-content-right">
					<div class="tour-description-content">
						<div class="tour-description-left">
							<div class="tour-number-info">
								<div class="tour-label">Статус тура:</div>
							</div>
						</div>
						<div class="tour-description-right">
							<div class="tour-people-info">
								<i class="icon-question"></i> <span>Путешественник найден</span>
							</div>
						</div>
					</div>
					<div class="tour-description-content">
						<div class="tour-description-left"></div>
						<div class="tour-description-right">
							<div class="tour-people-info">
								<i class="icon-message"></i> <a class="highlight-green" href="">Читать отзыв</a>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php if ($trip->status == TripManager::STATUS_ACTIVE) : ?>
			<button type="button" class="btn btn-sm btn-success <?= 'full' == $style ? 'hidden-md hidden-lg' : ''?>">
				<i class="icon-cart"></i> Купить шанс за <span><?= $di->tag->rub($trip->ticketPrice) ?></span>
			</button>
		<?php endif; ?>
		<?php if (in_array($trip->status, [TripManager::STATUS_SOON, TripManager::STATUS_WINNER_SEARCH])) : ?>
			<a class="btn btn-sm btn-default <?= 'full' == $style ? 'hidden-md hidden-lg' : ''?>" href="<?= $di->url->get(['for' => 'trip', 'id' => $trip->id])?>">Подробнее</a>
		<?php endif; ?>
		<?php if ($trip->status == TripManager::STATUS_ENDED) : ?>
			<button type="button" class="btn btn-sm btn-success <?= 'full' == $style ? 'hidden-md hidden-lg' : ''?>">Узнать победителя!</button>
		<?php endif; ?>
	</div>
</div>