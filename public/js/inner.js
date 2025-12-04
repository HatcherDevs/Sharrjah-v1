
checkBar();

$(document).ready(function(){
    resizeHeaders();
    $('.body-section .col-md-6.text-right a').css({ 'color': '#000'});
    $('.body-section .col-md-6.text-left a').css({ 'color': '#000'});
});

$(window).resize(function(){
    setTimeout(function(){
        $('.innerpage h1').css('height','auto');
        $('.innerpage .breadcrumbs').css('height','auto');
        resizeHeaders();
    },100);

    checkBar();
});

function checkBar(){
    if($(window).outerWidth()<992){
        $('#logo').addClass('twoline');
    } else {
        $('#logo').removeClass('twoline');
    }

    if($(document).scrollTop()>$('#header').height()){
        $('#logo').addClass('oneline');
    } else {
        $('#logo').removeClass('oneline');
    }

    $('#logo').fadeIn();
}

$(window).scroll(function(){
    checkBar();

    /**
     tt = $(document).scrollTop() / $('#header').outerHeight();
     tt = tt * 100;
     tt = tt > 100 ? 100: tt;
     tt = parseInt(tt - 100);

     $('#floating-header .menu-bar').css('right',tt+'%'); **/
});

function resizeHeaders(){

    var currentHeight=0;
    $('.innerpage h1').each(function(){
        if(parseInt($(this).css('height'))>currentHeight)
            currentHeight = parseInt($(this).css('height'));
    });

    console.log(currentHeight);
    $('.innerpage h1').css('height',currentHeight+'px');

    currentHeight=0;
    $('.innerpage .breadcrumbs').each(function(){
        if(parseInt($(this).css('height'))>currentHeight)
            currentHeight = parseInt($(this).css('height'));
    });
    $('.innerpage .breadcrumbs').css('height',currentHeight+'px');

}

