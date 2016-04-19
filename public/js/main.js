$(document).ready(function () {
	$("#mobile-icon-menu").click(function () {
		$('#content-overlay').fadeIn(300);
		$('#mobile-navigation').addClass('active');
		return false;
	});

	$("#content-overlay").click(function () {
		$(this).fadeOut(300);
		$('#mobile-navigation').removeClass('active');
		return false;
	});

	$('.card-goalchart-blue').circleProgress({
		startAngle: 1.5 * Math.PI,
		lineCap: 'round',
		emptyFill: '#edeff0',
		fill: { gradient: ["#92a8d1", "#3362a2"] }
	});
	$('.card-goalchart-green').circleProgress({
		startAngle: 1.5 * Math.PI,
		lineCap: 'round',
		emptyFill: '#edeff0',
		fill: { gradient: ["#88e504", "#538e00"] }
	});
});

var swiper = new Swiper('.swiper-welcome .swiper-container', {
	pagination: '.swiper-welcome .swiper-pagination',
	paginationClickable: true,
	nextButton: '.swiper-welcome .swiper-button-next',
	prevButton: '.swiper-welcome .swiper-button-prev'
});

var swiper = new Swiper('.swiper-how-work .swiper-container', {
	pagination: '.swiper-how-work .swiper-pagination',
	paginationClickable: true,
	paginationBulletRender: function (index, className) {
		return '<span class="' + className + '">' + (index + 1) + '</span>';
	}
});