<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 * @var \App\Main\Models\Trip $trip
 */
$di = $this->getDI();
?>
<div class="modal fade" id="popup_attempt_welcome" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a href="<?= $di->url->get(['for' => 'trips']) ?>" class="close"><span aria-hidden="true">&times;</span></a>
				<h4 class="modal-title text-center">Пройди географический квест</h4>
			</div>
			<div class="modal-body text-center">
				<div class="row">
					<div class="col-md-12">
						<p>Определите максимально точно местонахождение на карте. Если ваш ответ окажется самым точным — путешествие ваше!</p>
						<p>Шанс в этом туре стоит <?= $di->tag->rub($trip->ticketPrice )?>! Данная сумма спишется при старте географического квеста.</p>
						<p>У вас есть 5 минут, чтобы отметить ваше местоположение. Если вы не принимаете решение в указанное время, то сгорает одна попытка. На каждый тур у вас есть не более 3 попыток.</p>
						<p>Если у вас достаточно средств, то вы можете купить дополнительное время на ход, но таких покупок может быть не более 3, для данного тура!</p>
						<p>Удачи!</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-success js-new-attempt">Разыграть шанс!</button>
						<a href="<?= $di->url->get(['for' => 'trips']) ?>" class="btn btn-default">Вернуться к списку туров</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function WelcomePopup(options) {
		this.name = "popup_attempt_welcome";
		this.$popup = $('#' + this.name);

		this.options = $.extend({
			tripId: 0,
			onSuccess: function () {}
		}, options);

		this.show = function() {
			this.$popup.modal('show');
		};

		this.close = function() {
			this.$popup.modal('hide');
		};

		this.init = function () {
			var _this = this;
			_this.$popup
				.on('show.bs.modal', function (e) {
				})
				.on('shown.bs.modal', function (e) {
				})
				.on('click', '.js-new-attempt', function () {
					$.ajax({
						url: '<?= $di->url->get(['for' => 'attemptNew', 'id' => '{tripId}']) ?>'.replace('{tripId}', _this.options.tripId),
						success: function (response) {
							_this.options.onSuccess(response);
						}
					})
				})
			;
		};
		this.init();
	}
</script>