<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 */
use App\Main\Models\Attempt;
use App\Main\Models\Trip;

$di = $this->getDI();
?>
<main class="content-main">

	<section class="section container">
		<?php foreach ($winTrips as $data):
			/** @var Trip $trip */
			$trip = $data->trip;
			/** @var Attempt $attempt */
			$attempt = $data->attempt;
			?>
		<div class="user-chances-tour-content col-xs-6 col-md-6 col-lg-10 col-bg-10">
			<div class="user-chances-tour-title highlight-green">
				Вы выиграли тур
			</div>

			<div class="user-chances-tour-info">
				<div class="left-side">
					<a class="user-chances-tour-destination" href="#"><?= $trip->title?></a>
					<p class="user-chances-tour-place"><?= $trip->hotelTitle?></p>
				</div>

				<div class="right-side">
					<div class="user-chances-traveler-status highlight-green">
						<i class="icon-complete"></i>
						Путешественник найден
					</div>

					<div class="user-chances-tour-date"><?= $trip->startDt->format('d.m.Y') ?> – <?= $trip->endDt->format('d.m.Y') ?></div>
				</div>
			</div>

			<div class="user-chances-tour-list">
				<table class="table table-responsive">
					<thead>
					<tr>
						<th>Шанс</th>
						<th>Дата покупки</th>
						<th>Точность</th>
					</tr>
					</thead>

					<tbody>
					<tr>
						<td><?= $attempt->id ?></td>
						<td><?= $attempt->createdAt->format('m.d.Y H:i') ?></td>
						<td><a href="#"><?= $attempt->distance ?> км.</a></td>
					</tr>
					</tbody>
				</table>
			</div>

			<div class="user-chances-tour-button">
				<a class="btn btn-sm btn-success" href="#">Оформить документы</a>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="user-chances-tour-content col-xs-6 col-md-6 col-lg-10 col-bg-10 hide">
			<div class="user-chances-tour-title highlight-pink">Вы можете стать победителем!</div>

			<p>
				Время покупки шансов истекло, но не все шансы были куплены,
				Вы можете стать победителем, выкупив оставшуюся стоимость.
			</p>

			<div class="user-chances-tour-info">
				<div>
					<a class="user-chances-tour-destination" href="#">Египет, Шарм-эш-Шейх</a>
					<p class="user-chances-tour-place">Savoy Sharm El Sheikh</p>
				</div>

				<div class="right-side">
					<div class="user-chances-traveler-status highlight-sum">
						<i class="icon-search-circle"></i>
						Поиск путешественника
					</div>

					<div class="user-chances-tour-date">21.03.2016 – 28.03.2016</div>
				</div>
			</div>

			<div class="user-chances-timer">
				<div class="highlight-pink">
					<p class="user-chances-timer-title">До принятия решения осталось:</p>

					<div class="user-chances-timer-content">
						<div class="user-chances-timer-item">2</div
						><div class="user-chances-timer-item">3</div>
						<span>ч.</span>
						<div class="user-chances-timer-item">2</div
						><div class="user-chances-timer-item">2</div>
						<span>м.</span>
					</div>
				</div>


				<div class="highlight-green">
					<p class="user-chances-timer-title">Оставшаяся стоимость:</p>
					<div class="user-chances-timer-item">34,500 <i class="icon-rub-bold"></i></div>
				</div>
			</div>

			<div class="user-chances-tour-list">
				<table class="table">
					<thead>
					<tr>
						<th>Место</th>
						<th>Шанс</th>
						<th>Дата покупки</th>
						<th>Точность</th>
					</tr>
					</thead>

					<tbody>
					<tr>
						<td>1</td>
						<td>12</td>
						<td>Сегодня в 16:32</td>
						<td><a href="#">1,326.3 км.</a></td>
					</tr>
					<tr>
						<td>2</td>
						<td>33</td>
						<td>21.03.2016 в 12:23</td>
						<td><a href="">56,946.3 км.</a></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="user-chances-tour-button">
				<a class="btn btn-sm btn-default" href="#">Отказаться</a>
				<a class="btn btn-sm btn-success" href="#">Выкупить</a>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-3 col-bg-3">
				<div class="user-chances-menu">
					<ul>
						<li class="active"><i class="icon-paper"></i><a href="">Мои туры</a></li>
						<li><i class="icon-history"></i> <a href="">История операций</a></li>
						<li><i class="icon-setting"></i> <a href="">Настройки</a></li>
					</ul>
				</div>

				<div class="user-chances-support-info">
					<ul class="support-contacts">
						<li><i class="icon-mail"></i><a href="">support@tiptrip.com</a></li>
						<li><i class="icon-phone"></i><span>+7 (937) 300-25-34</span></li>
						<li><i class="icon-skype"></i><span>tiptripcom</span></li>
					</ul>
				</div>
			</div>

			<div class="user-chances-history col-lg-7 col-bg-7">
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Открытые</a></li>
					<li><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Закрытые</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<ul>
							<?php foreach ($tripsAttempts as $data):
								/** @var \App\Main\Models\Trip $trip */
								$trip = $data['trip'];
								?>
							<li>
								<div class="user-chances-tour-info">
									<div class="left-side">
										<a class="user-chances-tour-destination" href="#"><?= $trip->title ?></a>
										<p class="user-chances-tour-place"><?= $trip->hotelTitle ?></p>
									</div>

									<div class="right-side">
										<div class="user-chances-tour-date"><?= $trip->startDt->format('d.m.Y') ?> – <?= $trip->endDt->format('d.m.Y') ?></div>
									</div>
								</div>

								<div class="user-chances-tour-list">
									<table class="table">
										<thead>
										<tr>
											<th>Шанс</th>
											<th>Дата покупки</th>
											<th>Точность</th>
										</tr>
										</thead>

										<tbody>
										<?php
										/** @var Attempt $attempt */
										foreach ($data['attempts'] as $attempt): ?>
										<tr>
											<td><?= $attempt->id?></td>
											<td><?= $attempt->createdAt->format('d.m.Y H:i')?></td>
											<td><a href="#"><?= $attempt->distance ? $attempt->distance . '  км.' : ''?></a></td>
										</tr>
										<?php endforeach;?>
										</tbody>
									</table>
								</div>
							</li>
							<?php endforeach; ?>
					</div>

					<div role="tabpanel" class="tab-pane" id="profile">
						<ul>
							<?php foreach ($tripsAttemptsClosed as $data):
								/** @var \App\Main\Models\Trip $trip */
								$trip = $data['trip'];
								?>
								<li>
									<div class="user-chances-tour-info">
										<div class="left-side">
											<a class="user-chances-tour-destination" href="#"><?= $trip->title ?></a>
											<p class="user-chances-tour-place"><?= $trip->hotelTitle ?></p>
										</div>

										<div class="right-side">
											<div class="user-chances-tour-date"><?= $trip->startDt->format('d.m.Y') ?> – <?= $trip->endDt->format('d.m.Y') ?></div>
										</div>
									</div>

									<div class="user-chances-tour-list">
										<table class="table">
											<thead>
											<tr>
												<th>Шанс</th>
												<th>Дата покупки</th>
												<th>Точность</th>
											</tr>
											</thead>

											<tbody>
											<?php
											/** @var Attempt $attempt */
											foreach ($data['attempts'] as $attempt): ?>
												<tr>
													<td><?= $attempt->id?></td>
													<td><?= $attempt->createdAt->format('d.m.Y H:i')?></td>
													<td><a href="#"><?= $attempt->distance ? $attempt->distance . '  км.' : ''?></a></td>
												</tr>
											<?php endforeach;?>
											</tbody>
										</table>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
						<div class="user-chances-history-more">
							<i class="icon-arrow-down"></i><a href="#">Показать еще <span>50</span> шансов</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>