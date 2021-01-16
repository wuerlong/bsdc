$(document).ready(function() {

	$("#home-projects .thumb.it").hover(function() {
		var el = $(this).find(".info");
		TweenLite.to(el, 0.5, {css:{autoAlpha: 1}});
		var el = el.find(".inner");
		var h = (172 - el.height()) / 2;
		TweenLite.to(el, 0.01, {css:{paddingTop: h + "px"}});
	}, function() {
		var el = $(this).find(".info");
		TweenLite.to(el, 0.6, {css:{autoAlpha: 0}});
	});

	// elasticSlider
	$("#home").elasticFader({
		'autoRotate' : true,
		'min-width' : 800,
		'easing' : 'easeInOutCirc',
		'animationSpeed' : 2000,
		'loop' : true,
		'preloadImages' : true,
		'onStartLoading' : onPreloadImage,	
		'sliderOffsetY' : 0,
		'navContainer' : '#home-list-nav',
		'navClickToSlide' : true,
		'onAnimationStart' : onAnimationStart,
		'onAnimationComplete' : onAnimationComplete
	});
	initAnimations();

	function onPreloadImage() {
		showPreloader();
	}
	function initAnimations() {
		// wygaszam wszystkie opisy dla elementów nieaktywnych
		var notActiveDescr = $('#home li:not(.active) .home-description');
		notActiveDescr.children().each( function () {
			var el = $(this);
			TweenLite.to(el, 0.001, {css:{autoAlpha: 0, marginTop: "-8px"}});
		});
		// zapalam opis dla elementu aktywnego		
		$("#home li").first().addClass("active");
		onAnimationComplete(500);
	}
	function onAnimationStart() {
		// jeżeli boksy news albo portfolio są rozwinięte to je zwijam
		// if ($("#home-news .it").first().is(":visible")) 
		// 	toggleHomeNews();
		// if ($("#home-projects .it").first().is(":visible")) 
		// 	toggleHomeProjects();

		hidePreloader();

		var activeDescr = $("#home li.active .home-description");
		activeDescr.children().each( function () {
			var el = $(this);
			TweenLite.to(el, 0.3, {css:{autoAlpha: 0, marginTop: "-8px"}, ease:Back.easeOut});
		});
	}
	function onAnimationComplete(delay) {
		if (!delay) delay = 0;
		var activeDescr = $("#home li.active .home-description");
		activeDescr.children().each( function () {
			var myDelay = (delay + $(this).index() * 100) / 1000;
			var el = $(this);

			TweenLite.to(el, 0.5, {css:{autoAlpha: 1, marginTop: "0"}, delay:myDelay, ease:Back.easeOut});
		});
	}

});

