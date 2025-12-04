

/*********** HOME SCRIPTS **********************/
checkBar();
/**
 $('#shiftimg').mouseenter(function() {
			$(this).find('img').attr('src','img/home/2b.jpg')
		});

 $('#shiftimg').mouseleave(function() {
			$(this).find('img').attr('src','img/home/2.jpg')
		});

 $('#shiftimg2').mouseenter(function() {
			$(this).find('img').attr('src','img/home/Adrian2.jpg')
		});

 $('#shiftimg2').mouseleave(function() {
			$(this).find('img').attr('src','img/home/Adrian1.jpg')
		});
 **/
$(window).resize(function(){
    setTimeout(function(){
        $('.innerpage h1').css('height','auto');
        $('.innerpage .breadcrumbs').css('height','auto');
    },100);

    checkBar();
    checkScroll();
});

function checkBar(){
    if($(window).outerWidth()<992){
        $('#logo').addClass('twoline');
    } else {
        $('#logo').removeClass('twoline');
    }

    if($(document).scrollTop()>$('#header').height()){
    } else {
        $('#logo').removeClass('oneline');
    }

    $('#logo').fadeIn();
}

var mouseDown = false;

$(document).mousedown(function(){
    mouseDown = true;
});

$(document).on('touchstart',function(){
    mouseDown = true;
});

$(document).on('touchend',function(){
    mouseDown = false;
});

$(document).mouseup(function(){
    mouseDown = false;
});

var scrollAnimating = false;
console.log($(document).scrollTop());
console.log(parseInt($(window).outerHeight()));
if($(document).scrollTop() > parseInt($(window).outerHeight())){
    $('#floating-header').addClass('floating');
}

var marginLeft = 0;
$(window).resize(function(){
    alignVideo();
});

function alignVideo(){
    setTimeout(function(){

        if($('.home-video video').width()>$(window).outerWidth()){
            marginLeft = $('.home-video video').width()-$(window).outerWidth();
            marginLeft = marginLeft/2;
            $('.home-video video').css('margin-left','-'+(marginLeft-10)+'px');
        } else {
            $('.home-video video').css('margin-left','0');
        }

        if($('.margin-top-negative').height()>$(window).outerHeight()){
            marginTop = $('.home-video video').height()-$(window).outerHeight();
            marginTop = marginTop/2;

            $('.home-video video').css('margin-top','-'+(marginTop+70)+'px');
        }

    },100);

    setTimeout(function(){
        $('.home-video video').css('opacity',1);
    },100);
}

function checkScroll(){
    if($(document).scrollTop()>($('#home-video-container').height()+$('#header').height())){
        $('#floating-header .menu-bar').addClass('active');
    } else {
        $('#floating-header .menu-bar').removeClass('active');
    }

    if($(document).scrollTop()>(wHeight)+150){
        if(!$('#logo').hasClass('oneline'))
            $('#logo').addClass('oneline');
    }
    else {
        $('#logo').removeClass('oneline');
    }
}

$(window).scroll(function(){

    checkScroll();

    /** $('#scoller').html($(document).scrollTop());
     $('#dimensions').html($(window).outerWidth()+'x'+$(window).outerHeight());
     $('#home-video').html($(window).outerHeight()); **/

    wHeight = parseInt($('.home-video').outerHeight());

    if($(document).scrollTop()>100){
        $('#scroll-down').hide();
    } else {
        $('#scroll-down').show();
    }

    if($(document).scrollTop()>(wHeight)){
        $('#floating-header').addClass('floating');
    }
    else if($(document).scrollTop()<(wHeight)+60) {
        $('#floating-header').css('top','30px').css('right','0').removeClass('floating');
    }

    $('#menu-bt-close').trigger('click');

    if(!scrollAnimating){
        hHeight = wHeight/2;
        if( $(document).scrollTop()>0 && $(document).scrollTop()<hHeight && scrollAnimating == false){
            if(!mouseDown){
                scrollAnimating = true;
                $('html, body').animate({
                    scrollTop: wHeight+($(window).width()<630 ? 45 : 60 )
                }, 600, function(){

                    scrollAnimating = false;
                    $('#floating-header').addClass('floating');
                });
            }
        }
        else if ( $(document).scrollTop()<(wHeight) && $(document).scrollTop() > (wHeight/2) && scrollAnimating == false ) {
            if(!mouseDown){
                scrollAnimating = true;
                $('html, body').animate({
                    scrollTop: 0
                }, 600, function(){
                    scrollAnimating = false;
                });
            }
        }
    }
});

$('#scroll-down').on('click', function(){
    if($(window).outerWidth() > 620)
        window.scroll(0,5);
    else
        $('html, body').animate({ scrollTop: wHeight+60 }, 300);
});

$('#video-menu').on('click', function(e){
    e.preventDefault();
    showMenu();
});

$(document).ready(function(){
    checkScroll();


    setTimeout(function(){alignVideo()},1000);
});