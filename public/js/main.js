
toggleSearch();
resizeHomeVideo();
verticalAlign();


function resizeHomeVideo() {
	wHeight = parseInt($(window).outerHeight());

	if (wHeight > 420) {

		$('.auto-height').css('height', wHeight + 'px');
		$('.auto-height-holder').css('height', (wHeight) + 'px');

		$('.home-video').css('height', wHeight + 'px');
		$('.headline').css('height', (wHeight) + 'px');

	} else {

		$('.auto-height').css('height', wHeight + 'px');
		$('.auto-height-holder').css('height', (wHeight) + 'px');

		$('.home-video').css('height', '900px');
		$('.headline').css('height', '900px');
	}
}

$(window).resize(function () {
	setTimeout(function () {
		if ($(window).outerWidth() > 420) {
			resizeHomeVideo();
			toggleSearch();
		}
		if ($(window).outerHeight() < 520) {
			$('#menu .mobile').css('overflow-y', 'scroll');
			$('#menu .mobile').css('height', $(window).outerHeight() - parseInt($('#menu .mobile').css('margin-top')));
		}
		else {
			$('#menu .mobile').css('height', 'auto').css('overflow-y', 'hidden');
		}
	}, 100);

	$('#menu-bt-close').trigger('click');
});

var scrollAnimating = false;

function verticalAlign() {
	$('.v-content').each(function () {
		$(this).css('margin-top', ('-' + $(this).height() / 2) + 'px');
	});
	$('.v-content.nav-section').each(function () {
		$(this).css('margin-top', '-' + (($(this).height() / 2) + 50) + 'px');
	});
}


function showMenu() {
	if (!$('#menu ul li ul').hasClass('animating')) {

		$('.auto-height').css('height', parseInt($(window).outerHeight()) + 'px');
		$('.auto-height-holder').css('height', (parseInt($(window).outerHeight())) + 'px');

		$('#menu').show();
		$('#menu-bt').hide();
		$('body').addClass('disableScroll');
		$('#search-bt').show().css('display', 'block');
		$('#menu-bt-close').show().css('display', 'block');
		$('#menu ul li ul').css('margin-top', '-100%');

		$('#menu .v-content').animate({
			opacity: 1
		}, 300);

		$('#menu .v-content').css('width', $('#menu .auto-height-holder').width() - 30);

		$('#menu').animate({
			top: "0",
			right: "0",
		}, 500, function () {
			$('#menu ul li ul').addClass('animating');


			setTimeout(function () {
				$('.english-nav').animate({
					top: '105%',
					opacity: 1
				}, 400);
				$('.arabic-nav').animate({
					bottom: '105%',
					opacity: 1
				}, 400);
			}, 100);

			$('#menu ul li ul').removeClass('animating');

		});

		$('#menu ul li ul').animate({
			marginTop: "0"
		}, 200, function () {
		});

		verticalAlign();

	}
}

$('.mobile .cat').on('click', function (e) {

	if ($(this).closest('a').attr('href') == '#')
		e.preventDefault();

	$('.mobile .cat').hide();
	$(this).show();
	$('#mobile-menu-back').show();
	$(this).closest('li').find('ul').show();
	link = $(this).closest('a').attr('alt');
	$(this).closest('a').attr('href', link);

});

$('#mobile-menu-back').on('click', function (e) {

	e.preventDefault();
	$('#menu .mobile ul li ul').hide();
	$('#menu .mobile ul li .cat').show();
	$(this).hide();


	$('#menu .mobile ul li .cat').each(function () {
		$(this).closest('a').attr('href', '#');
	});

});

$('.menu-click').on('click', function (e) {
	e.preventDefault();
	showMenu();
});

$('.search-click').on('click', function (e) {

	e.preventDefault();

	$('.search-click').hide();
	if ($(window).outerWidth() > 767) {
		if ($(this).hasClass('active')) {
		}
		else {
			if ($('#menu').css('top') != "0px")
				showMenu();

			$(this).addClass('active');

			if ($('#main-logo').width() + parseInt($('#floating-header').css('padding-left')) + 20 < parseInt($('#menu .auto-height-holder').css('padding-left')))
				$('#search').width($('#floating-header').width() - parseInt($('#menu .auto-height-holder').css('padding-left')));
			else
				$('#search').width($('#floating-header').width() - parseInt($('#main-logo').width()) - 60);

			$('#search').fadeIn().trigger('focus');
			$('#search-submit').show();
		}
	}
});

$('.menu-close-click').on('click', function (e) {

	e.preventDefault();
	if (!$('#menu ul li ul').hasClass('animating')) {

		$('#header').removeClass('active');
		$('#menu-bt-close').hide();
		$('#search-bt').hide();
		$('#menu-bt').show();
		$('body').removeClass('disableScroll');

		$('#search').fadeOut();
		$('#search-submit').fadeOut();
		$('#search-bbt').removeClass('active');

		$('#menu ul li ul').addClass('animating');

		$('#menu .v-content').animate({
			opacity: 0
		}, 100);

		$('#menu').animate({
			top: "-105%",
			right: "-205%",
		}, 500, function () {

			$('.english-nav').css('top', '10%').css('opacity', '0');
			$('.arabic-nav').css('bottom', '10%').css('opacity', '0');

			$('#menu ul li ul').removeClass('animating');
			$('#menu').hide();
		});
	}
});

function toggleSearch() {
	if ($(window).outerWidth() < 767) {
		$('#search-bt').attr('data-toggle', "modal").attr('data-target', "#searchModal");
	} else {
		$('#search-bt').removeAttr('data-toggle').removeAttr('data-target');
	}
}

// $('#menu .buttons form').focusout(function(){
// 	$('#search').hide().val('');
// 	$('#search-submit').hide();
// 	$('#search-bt').removeClass('active').show();
// });

toggleSearch();


// $(".item img").css({"display":"none");

// On window load. This waits until images have loaded which is essential
$(window).on('load', function () {


	// Fade image 
	$('.featured img').mouseover(function () {
		$(this).parent().find('img:first').stop().animate({ opacity: 1 }, 1000);
	})
	$('#featured-list .featured a img grayscale').mouseout(function () {
		$(this).stop().animate({ opacity: 0 }, 1000);
	});
});

// Grayscale w canvas method
function grayscale(src) {
	var canvas = document.createElement('canvas');
	var ctx = canvas.getContext('2d');
	var imgObj = new Image();
	imgObj.src = src;
	canvas.width = imgObj.width;
	canvas.height = imgObj.height;
	ctx.drawImage(imgObj, 0, 0);
	var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
	for (var y = 0; y < imgPixels.height; y++) {
		for (var x = 0; x < imgPixels.width; x++) {
			var i = (y * 4) * imgPixels.width + x * 4;
			var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
			imgPixels.data[i] = avg;
			imgPixels.data[i + 1] = avg;
			imgPixels.data[i + 2] = avg;
		}
	}
	ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
	return canvas.toDataURL();
}

setInterval(() => {
	document.querySelectorAll('.show-placeholder a').forEach(ele => {
		if (ele.text == "Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.") {
			ele.style.display = "none"
		}
	})
	document.querySelectorAll('#fr-logo').forEach(ele => {
		$(ele).remove()
	})
	$('#fr-logo').remove();
	document.querySelectorAll('[data-f-id="pbf"]').forEach(ele => {
		$(ele).remove()
	})
	$('[data-f-id="pbf"]').remove()
}, 100);