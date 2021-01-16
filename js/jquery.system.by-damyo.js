$(document).ready(function() {
	if($('div#contents').length > 0) {
		$('div#contents, div#bottom, div#info_box').hide();
	}
});
$(window).load(function() {
	var navSlideWidth = 105;
	var navBgX = 105;
	var systemNav = "close";
	var hommeNav = "close";
	var winResize = "false";
	var imgBoxResize = "true";
	var gender = $('body').attr('class');
	var fullScreenMargin = 0;
	var imgBoxLeft = 0;
	var infoBoxLeft = 0;
	var no = 0;
	var totalNum = $('p.page span.total').text();

	$('div#bottom h2').css('cursor', 'pointer').click(function() {
		location.href = 'index.html';
	});

	$(window).resize(function() {
		if($('div#contents').css('display') == "none") {
			$('div#contents, div#info_box').fadeIn(400, function() {
				$('div#bottom').show();	
			});
		} else {
			$('div#bottom').show();	
		}
		if(navigator.userAgent.match('iPhone') != null && navigator.userAgent.match('Version') != null && $(this).innerHeight() != 460 && $(this).innerHeight() != 300) {
			$('body, div#index, div#contents, div#info, div.image_box').css('height', $(this).innerHeight() + 60);
			if($(this).innerHeight() != 320) {
				$('h2.homme').css('bottom', '-60px');
				$('div#info_box').css('top', ($(this).innerHeight() + 60) / 2);
			} else {
				$('body, div#index, div#contents, div#info, div.image_box').css('height', $(this).innerHeight());
				$('h2.homme').css('bottom', '0');
				$('div#info_box').css('top', '50%');
			}
		} else {
			$('body, div#index, div#contents, div#info, div.image_box').css('height', $(this).innerHeight());
			$('div#info_box').css('top', '50%');
		}
		if(navigator.userAgent.match('Android') != null) {
			$('div#bottom').css('position', 'absolute');
		}

		if($(this).width() > 480) {
			navBgX = 0;
			navSlideWidth = 210;
			$('h2').css('background-position', '0 0');
		} else {
			navBgX = 105;
			navSlideWidth = 105;
			$('h2').css('background-position', '-105px 0');
		}
		//if($('body').width() / 3 < $('body').height() / 2) {
		//	$('div#index p img').css({'width': '', 'height': $('body').height()});
			//var thisWidth = $('div#index p img').width();
			//$('div#index p img').css({'left': '50%', 'margin-left': -(thisWidth / 2)});
		//} else {
			//$('div#index p img').css({'width': $('body').width(), 'height': '', 'left': 0, 'margin-left': 0});
		//}
		$('img.full_screen').css('height', $('body').innerHeight());
		if(no == 0) {
			fullScreenMargin = $('img.full_screen').eq(0).width() / 2;
			$('img.full_screen').css('margin-left', - fullScreenMargin);
		}
		if(imgBoxResize == "true") {
			$('div.image_box').each(function(count) {
				if(systemNav == "open" && count == no) {
					$(this).css('left', $('body').width() * count + navSlideWidth + 'px');
				} else if(hommeNav == "open" && count == currentImgNo) {
					$(this).css('left', $('body').width() * count - navSlideWidth + 'px');
				} else {
					$(this).css('left', $('body').width() * count + 'px');
				}
			});
			if(systemNav == "open") {
				$('div#index').css('left', navSlideWidth + 'px');
				$('div#info_box').css({'margin-left': -$('div#info_box').width() / 2 + navSlideWidth, 'margin-top': -$('div#info_box').height() / 2});
			} else if(hommeNav == "open") {
				$('div#index').css('left', -navSlideWidth + 'px');
				$('div#info_box').css({'margin-left': -$('div#info_box').width() / 2 - navSlideWidth, 'margin-top': -$('div#info_box').height() / 2});
			} else {
				$('div#index').css('left', '0');
				$('div#info_box').css({'margin-left': -$('div#info_box').width() / 2, 'margin-top': -$('div#info_box').height() / 2});
			}
		}
		if(winResize == "true") {
			$('div#contents').css('left', -$('body').width() * no + 'px');
		}
		$(this).scrollTop(0).scrollLeft(0);
	});
	$(window).trigger('resize');

	var cookie = document.cookie;
	var cookieAlive = cookie.indexOf("firstVisit=false");

	if(cookieAlive != -1) {
		$('div#info').remove();
	} else {
		$('div#info').fadeTo(400, .6).click(function() {
			$(this).fadeTo(400, 0, function() {
				$(this).hide();
			});
		});
		var GIFPath = '/mobile/images/common/info.gif?rand=' + Math.random();
		var $GIFImage = $('<img src="' + GIFPath + '"/ >');
		$('div#info img').attr('src', GIFPath).show();
		$GIFImage.bind('load', function() {
			var timer = setInterval(function() {
				$('div#info').fadeTo(400, 0, function() {
					$(this).hide();
				});
			}, 7300);
		});
		document.cookie ="firstVisit = false" + "; max-age = " + (60 * 60 * 24 * 365);
	}

	if(navigator.userAgent.match('iPhone') != null || navigator.userAgent.match('iPad') != null) {
		$('nav h2.system').swipe({
			click: function() {
				$(window).scrollTop(0);
				systemClick();
			}, swipe: function() {
				$(window).scrollTop(0);
				return false;
			}
		});

		$('nav h2.homme').swipe({
			click: function() {
				$(window).scrollTop(0);
				hommeClick();
			}, swipe: function() {
				$(window).scrollTop(0);
				return false;
			}
		});

		$('div#bottom a').swipe({
			click: function(e) {
				e.preventDefault();
				location.href = $(e.target).attr('href');
			}, swipe: function() {
				$(window).scrollTop(0);
				return false;
			}
		});
	} else {
		$('nav h2.system').click(function() {
			$(window).scrollTop(0);
			systemClick();
		}).swipe({
			swipe: function() {
				$(window).scrollTop(0);
				return false;
			}
		});

		$('nav h2.homme').click(function() {
			$(window).scrollTop(0);
			hommeClick();
		}).swipe({
			swipe: function() {
				$(window).scrollTop(0);
				return false;
			}
		});
	}

	function imgBoxResizeSetting() {
		imgBoxResize = "true";
	}
	
	function systemClick() {
		imgBoxLeft = parseInt($('div.image_box').eq(no).css('left'));
		infoBoxLeft = parseInt($('div#info_box').css('margin-left'));
		if(systemNav != "open" && hommeNav == "open") {
			imgBoxResize = "false";
			$('nav h2.homme').show();
			$('div#index').animate({left: 0}, 200, function() {
				$('div#bottom div#homme, div#bottom h2.homme').css('z-index', 0);
				$(this).animate({left: navSlideWidth + 'px'}, 200, function() {
					$('div#bottom h2.system').css('z-index', 400);
					$('div#bottom div#system').css('z-index', 300);
					$(this).animate({left: imgBoxLeft + (navSlideWidth * 2) + 'px'}, 200);
					$('nav h2.system').hide();
				});
			});
			$('div.image_box').eq(no).animate({left: imgBoxLeft + navSlideWidth + 'px'}, 200, function() {
				$('div#bottom div#homme, div#bottom h2.homme').css('z-index', 0);
				$(this).animate({left: imgBoxLeft + (navSlideWidth * 2) + 'px'}, 200);
			});
			hommeNav = "close";
			systemNav = "open";
			$('div#info_box').animate({marginLeft: infoBoxLeft + (navSlideWidth * 2) + 'px'}, 400, function() {
				imgBoxResizeSetting();
				$('div#bottom h2.system').css('z-index', 400);
				$('div#bottom div#system').css('z-index', 300);
				$('nav h2.system').hide();
			});
		} else if(systemNav != "open") {
			imgBoxResize = "false";
			$('div#bottom div#homme, div#bottom h2.homme').css('z-index', 0);
			$('div#index').animate({left: navSlideWidth + 'px'}, 250, function() {
				$('div#bottom h2.system').css('z-index', 400);
				$('div#bottom div#system').css('z-index', 300);
				$('nav h2.system').hide();
			});
			$('div.image_box').eq(no).animate({left: imgBoxLeft + navSlideWidth + 'px'}, 250);
			$('div#info_box').animate({marginLeft: infoBoxLeft + navSlideWidth + 'px'}, 250, function() {
				imgBoxResizeSetting();
				$('div#bottom h2.system').css('z-index', 400);
				$('div#bottom div#system').css('z-index', 300);
				$('nav h2.system').hide();
			});
			hommeNav = "close";
			systemNav = "open";
		}
	}
	function hommeClick() {
		imgBoxLeft = parseInt($('div.image_box').eq(no).css('left'));
		infoBoxLeft = parseInt($('div#info_box').css('margin-left'));
		if(hommeNav != "open" && systemNav == "open") {
			imgBoxResize = "false";
			$('nav h2.system').show();
			$('div#index').animate({left: 0}, 200, function() {
				$('div#bottom div#system, div#bottom h2.system').css('z-index', 0);
				$(this).animate({left: -navSlideWidth + 'px'}, 200, function() {
					$('div#bottom h2.homme').css('z-index', 400);
					$('div#bottom div#homme').css('z-index', 300);
					$(this).animate({left: imgBoxLeft - (navSlideWidth * 2) + 'px'}, 200);
					$('nav h2.homme').hide();
				});
			});
			$('div.image_box').eq(no).animate({left: imgBoxLeft - navSlideWidth + 'px'}, 200, function() {
				$('div#bottom div#system, div#bottom h2.system').css('z-index', 0);
				$(this).animate({left: imgBoxLeft - (navSlideWidth * 2) + 'px'}, 200);
			});
			systemNav = "close";
			hommeNav = "open";
			$('div#info_box').animate({marginLeft: infoBoxLeft - (navSlideWidth * 2) + 'px'}, 400, function() {
				imgBoxResizeSetting();
				$('div#bottom h2.homme').css('z-index', 400);
				$('div#bottom div#homme').css('z-index', 300);
				$('nav h2.homme').hide();
			});
		} else if(hommeNav != "open") {
			imgBoxResize = "false";
			$('div#bottom div#system, div#bottom h2.system').css('z-index', 0);
			$('div#index').animate({left: -navSlideWidth + 'px'}, 250, function() {
				$('div#bottom h2.homme').css('z-index', 400);
				$('div#bottom div#homme').css('z-index', 300);
				$('nav h2.homme').hide();
			});
			$('div.image_box').eq(no).animate({left: imgBoxLeft - navSlideWidth + 'px'}, 250);
			$('div#info_box').animate({marginLeft: infoBoxLeft - navSlideWidth + 'px'}, 250, function() {
				imgBoxResizeSetting();
				$('div#bottom h2.homme').css('z-index', 400);
				$('div#bottom div#homme').css('z-index', 300);
				$('nav h2.homme').hide();
			});
			systemNav = "close";
			hommeNav = "open";
		}
	}

	$('div#index').swipe({
		click: function() {
			$(window).scrollTop(0);
			$('div#bottom div#system, div#bottom h2.system, div#bottom div#homme, div#bottom h2.homme').css('z-index', 0);
			if(systemNav == "open") {
				$('div#index').animate({left: 0}, 250);
				$('nav h2.system').show();
				systemNav = "close";
			} else if(hommeNav == "open") {
				$('div#index').animate({left: 0}, 250);
				$('nav h2.homme').show();
				hommeNav = "close";
			}
		}, swipeLeft: function() {
			//$(window).scrollTop(0);
			//hommeClick();
		}, swipeRight: function() {
			$(window).scrollTop(0);
			systemClick();
		}
	});

	function rightSwipe() {
		if(systemNav != "open" && hommeNav != "open") {
			if(no > 0) {
				winResize = "false";
				no--;
				$('div#contents').stop(true, false).animate({left: -$('body').width() * no}, 500, function() {
					winResize = "true";
					$('p.page').remove();
					$('div#info_box p.next').before('\t\t<p class="page"><span class="current">' + (no + 1) + '</span> / <span class="total">' + totalNum + '</span></p>');
				});
			} else {
				if($('div#info_box').css('display') == "none") {
					$('p.page').remove();
					$('div#info_box p.prev, div#info_box p.next').css('display', 'none');
					$('div#info_box p.next').before('\t\t<p class="page"><span class="caution">没有更多的图片了.</span></p>');
					$('div#info_box').fadeIn(50, function() {
						setTimeout(function() {
							$('div#info_box').fadeOut(100, function() {
								$('div#info_box p.prev, div#info_box p.next').css('display', 'block');
								$('p.page').remove();
								$('div#info_box p.next').before('\t\t<p class="page"><span class="current">' + (no + 1) + '</span> / <span class="total">' + totalNum + '</span></p>');
							});
						}, 500);
					});
				} else {
					$('p.page').remove();
					$('div#info_box p.prev, div#info_box p.next').css('display', 'none');
					$('div#info_box p.next').before('\t\t<p class="page"><span class="caution">没有更多的图片了.</span></p>');
					setTimeout(function() {
						$('div#info_box p.prev, div#info_box p.next').css('display', 'block');
						$('p.page').remove();
						$('div#info_box p.next').before('\t\t<p class="page"><span class="current">' + (no + 1) + '</span> / <span class="total">' + totalNum + '</span></p>');
					}, 500);
				}
			}
		}
	}
	function leftSwipe() {
		if(systemNav != "open" && hommeNav != "open") {
			if(no < totalNum - 1) {
				winResize = "false";
				no++;
				var $img = $('<img src="images/' + gender + '/p' + no + '.png" />');
				if($('div.image_box img').eq(no).attr('src') != 'images/' + gender + '/p' + no + '.png" ' || !($('div.image_box img').eq(no).attr('src'))) {
					$('p.page').remove();
					$('div#info_box p.next').before('\t\t<p class="page">&nbsp;<img src="images/loading.gif" />&nbsp;</p>');
					$('div#contents').append('<div class="image_box" style="display: none;"><img src="images/' + gender + '/p' + no + '.png" class="full_screen" style="height: ' + $('body').innerHeight() + ';" /></div>');
				}
				$img.bind('load', function() {
					$('div.image_box').eq(no).css({'top': 0, 'left': $('body').width() * no, 'height': $('body').innerHeight(), 'display': 'block'});
					fullScreenMargin = $('img.full_screen').eq(no).width() / 2;
					$('div.image_box img').eq(no).css('margin-left', -fullScreenMargin);
					$('div#contents').stop(true, false).animate({left: -$('body').width() * no}, 500, function() {
						winResize = "true";
						$('p.page').remove();
						$('div#info_box p.next').before('\t\t<p class="page"><span class="current">' + (no + 1) + '</span> / <span class="total">' + totalNum + '</span></p>');
					});
				});
			} else {
				if($('div#info_box').css('display') == "none") {
					$('p.page').remove();
					$('div#info_box p.prev, div#info_box p.next').css('display', 'none');
					$('div#info_box p.next').before('\t\t<p class="page"><span class="caution">没有更多的图片了。</span></p>');
					$('div#info_box').fadeIn(50, function() {
						setTimeout(function() {
							$('div#info_box').fadeOut(100, function() {
								$('div#info_box p.prev, div#info_box p.next').css('display', 'block');
								$('p.page').remove();
								$('div#info_box p.next').before('\t\t<p class="page"><span class="current">' + (no + 1) + '</span> / <span class="total">' + totalNum + '</span></p>');
							});
						}, 500);
					});
				} else {
					$('p.page').remove();
					$('div#info_box p.prev, div#info_box p.next').css('display', 'none');
					$('div#info_box p.next').before('\t\t<p class="page"><span class="caution">没有更多的图片了.</span></p>');
					setTimeout(function() {
						$('div#info_box p.prev, div#info_box p.next').css('display', 'block');
						$('p.page').remove();
						$('div#info_box p.next').before('\t\t<p class="page"><span class="current">' + (no + 1) + '</span> / <span class="total">' + totalNum + '</span></p>');
					}, 500);
				}
			}
		}
	}

	$('div#contents, div#info_box').swipe({
		click: function(event) {
			$(window).scrollTop(0);
			if($(event.target).parent().attr('class') == "prev" && systemNav == "close" && hommeNav == "close") {
				rightSwipe();
				return false;
			} else if($(event.target).parent().attr('class') == "next" && systemNav == "close" && hommeNav == "close") {
				leftSwipe();
				return false;
			} else {
				$('div#bottom div#system, div#bottom h2.system, div#bottom div#homme, div#bottom h2.homme').css('z-index', 0);
				imgBoxLeft = parseInt($('div.image_box').eq(no).css('left'));
				infoBoxLeft = parseInt($('div#info_box').css('margin-left'));
				if(systemNav == "open") {
					imgBoxResize = "false";
					systemNav = "close";
					$('nav h2.system').show();
					$('div.image_box').eq(no).animate({left: imgBoxLeft - navSlideWidth + 'px'}, 250);
					$('div#info_box').animate({marginLeft: infoBoxLeft - navSlideWidth + 'px'}, 250, function() {imgBoxResizeSetting();});
				} else if(hommeNav == "open") {
					imgBoxResize = "false";
					hommeNav = "close";
					$('nav h2.homme').show();
					$('div.image_box').eq(no).animate({left: imgBoxLeft + navSlideWidth + 'px'}, 250);
					$('div#info_box').animate({marginLeft: infoBoxLeft + navSlideWidth + 'px'}, 250, function() {imgBoxResizeSetting();});
				} else if($('div#info_box').css('display') == "none") {
					$('div#info_box').fadeIn(400);
				} else {
					$('div#info_box').fadeOut(400);
				}
			}
		}, swipeLeft: function() {
			$(window).scrollTop(0);
			leftSwipe();
		}, swipeRight: function() {
			$(window).scrollTop(0);
			rightSwipe();
		}, swipeUp: function() {
			//$(window).scrollTop(0);
			//return false;
		}, swipeDown: function() {
			//$(window).scrollTop(0);
			//return false;
		}
	});
	
	$('#store_select').click(function() {
			$('#mapcont').show();
		})

});