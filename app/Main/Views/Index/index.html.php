<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Models\Trip[] $trips
 * @var App\Main\Components\DI $di
 */
$di = $this->getDI();
?>
<section class="how-work-wrapper section container">
	<div class="section-title">Как это работает</div>
	<div class="row hidden-sm hidden-xs">
		<div class="col-lg-5 col-md-5">
			<div class="how-work-step">
				<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_1.png" alt=""></div>
				<span>Шаг 1</span>
				<h2>Зарегистрируйся</h2>
				<p>Вам нужно потратить чуточку времени, чтобы присоединиться к нашим удачливым путешественникам.
					Совсем короткая форма регистрации, надеемся, не сильно вас утомит.</p>
			</div>
		</div>
		<div class="col-lg-5 col-md-5">
			<div class="how-work-step">
				<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_2.png" alt=""></div>
				<span>Шаг 2</span>
				<h2>Выберите путешествие</h2>
				<p>На карточке путешествия есть вся информация: страна, количество путешественников, длительность
					и стоимость шанса. Если все понравилось, нажмите Начать. Оплатите шанс минимальным платежом.</p>
			</div>
		</div>
		<div class="col-lg-5 col-md-5">
			<div class="how-work-step">
				<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_3.png" alt=""></div>
				<span>Шаг 3</span>
				<h2>Пройди географический квест</h2>
				<p>Определите максимально точно местонахождение на карте. Если ваш ответ окажется самым точным — путешествие ваше!</p>
			</div>
		</div>
		<div class="col-lg-5 col-md-5">
			<div class="how-work-step">
				<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_4.png" alt=""></div>
				<span>Шаг 4</span>
				<h2>Пакуйте чемоданы!</h2>
				<p>Отслеживать статус вашего шанса на сайте. И, возможно, паковать чемоданы!</p>
			</div>
		</div>
	</div>
	<div class="swiper-how-work hidden-lg hidden-md">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide how-work-step">
					<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_1.png" alt=""></div>
					<span>Шаг 1</span>
					<h2>Зарегистрируйся</h2>
					<p>Вам нужно потратить чуточку времени, чтобы присоединиться к нашим удачливым путешественникам.
						Совсем короткая форма регистрации, надеемся, не сильно вас утомит.</p>
				</div>
				<div class="swiper-slide how-work-step">
					<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_2.png" alt=""></div>
					<span>Шаг 2</span>
					<h2>Выберите путешествие</h2>
					<p>На карточке путешествия есть вся информация: страна, количество путешественников, длительность
						и стоимость шанса. Если все понравилось, нажмите Начать. Оплатите шанс минимальным платежом.</p>
				</div>
				<div class="swiper-slide how-work-step">
					<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_3.png" alt=""></div>
					<span>Шаг 3</span>
					<h2>Пройди географический квест</h2>
					<p>Определите максимально точно местонахождение на карте. Если ваш ответ окажется самым точным — путешествие ваше! </p>
				</div>
				<div class="swiper-slide how-work-step">
					<div class="how-work-step-icon"><img src="images/index/icons_how_work/icon_step_4.png" alt=""></div>
					<span>Шаг 4</span>
					<h2>Пакуйте чемоданы!</h2>
					<p>Отслеживать статус вашего шанса на сайте. И, возможно, паковать чемоданы!</p>
				</div>
			</div>
			<!-- Add Pagination -->
			<div class="swiper-pagination"></div>
		</div>
	</div>
	<div class="support">
		<div class="support-title">Остались вопросы?</div>
		<div>Обратитесь в <i class="icon-support"></i> <a class="highlight-link" href="">Службу поддержки</a></div>
	</div>
</section>
<section class="reviews-wrapper section section-bg">
	<div class="container">
		<div class="section-title">Отзывы победителей</div>
		<div class="row">
			<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
				<div class="review-item col-bg">
					<div class="review-item-header">
						<div class="review-item-user">
							<div class="review-item-avatar"><img src="images/delete/review_avatar.jpg" alt=""></div>
							<span>Юлия Титова</span>
						</div>
						<div class="social-wrapper">
							<a class="icon-fb" href="/"></a>
							<a class="icon-tw" href="/"></a>
						</div>
					</div>
					<p>Заказали тур в Геленджик, оплатив полную стоимость. Через два дня сообщают, что 3 дня из 7 придётся жить в эконом
						номере вместо стандарта (доплатив 1000!) или заселиться в другой пансионат... <a href="">Читать полностью</a></p>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
				<div class="review-item col-bg">
					<div class="review-item-header">
						<div class="review-item-user">
							<div class="review-item-avatar"><img src="images/delete/review_avatar.jpg" alt=""></div>
							<span>Юлия Титова</span>
						</div>
						<div class="social-wrapper">
							<a class="icon-tw" href="/"></a>
						</div>
					</div>
					<p>Заказали тур в Геленджик, оплатив полную стоимость. Через два дня сообщают, что 3 дня из 7 придётся жить в эконом
						номере вместо стандарта (доплатив 1000!) или заселиться в другой пансионат... <a href="">Читать полностью</a></p>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
				<div class="review-item col-bg">
					<div class="review-item-header">
						<div class="review-item-user">
							<div class="review-item-avatar"><img src="images/delete/review_avatar.jpg" alt=""></div>
							<span>Юлия Титова</span>
						</div>
						<div class="social-wrapper">
							<a class="icon-fb" href="/"></a>
						</div>
					</div>
					<p>Заказали тур в Геленджик, оплатив полную стоимость. Через два дня сообщают, что 3 дня из 7 придётся жить в эконом
						номере вместо стандарта (доплатив 1000!) или заселиться в другой пансионат... <a href="">Читать полностью</a></p>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
				<div class="review-item col-bg">
					<div class="review-item-header">
						<div class="review-item-user">
							<div class="review-item-avatar"><img src="images/delete/review_avatar.jpg" alt=""></div>
							<span>Юлия Титова</span>
						</div>
						<div class="social-wrapper">
							<a class="icon-vk" href="/"></a>
							<a class="icon-fb" href="/"></a>
							<a class="icon-tw" href="/"></a>
						</div>
					</div>
					<p>Заказали тур в Геленджик, оплатив полную стоимость. Через два дня сообщают, что 3 дня из 7 придётся жить в эконом
						номере вместо стандарта (доплатив 1000!) или заселиться в другой пансионат... <a href="">Читать полностью</a></p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="tours-wrapper tours-preview section container">
	<div class="section-title">Активные туры:</div>
	<div class="row">
		<?= $this->getContent(); ?>
		<?php foreach ($trips as $trip): ?>
			<?= $this->partial("shared/trip_card", ['trip' => $trip, 'style' => 'min']); ?>
		<?php endforeach; ?>
	</div>
	<div class="text-center tours-all-link">
		<a href="<?= $this->url->get(['for' => 'trips'])?>">Смотреть все туры</a>
	</div>
</section>
<section class="registration-block-wrapper section section-bg">
	<div class="container text-center">
		<div class="registration-block-title">Все еще <span>копишь на отпуск?</span></div>
		<p>Хватит это терпеть!</p>
		<?= $di->tag->popupButton(
			'Регистрация',
			'registration',
			['data-page' => 'login', 'class' => 'btn btn-lg btn-default', 'type' => 'button']
		) ?>
	</div>
</section>
<section class="partners-wrapper section container">
	<img src="/images/partners/biblio_globus.jpg" alt="">
	<img src="/images/partners/pegas.jpg" alt="">
	<img src="/images/partners/panteon.jpg" alt="">
	<img src="/images/partners/itm.jpg" alt="">
	<img src="/images/partners/teztour.jpg" alt="">
	<img src="/images/partners/elite_travel.jpg" alt="">
</section>