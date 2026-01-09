
var stylers = [{ "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }] }, { "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] }, { "elementType": "labels.text.fill", "stylers": [{ "color": "#949494" }] }, { "elementType": "labels.text.stroke", "stylers": [{ "color": "#f7f7f7" }] }, { "featureType": "administrative.land_parcel", "stylers": [{ "visibility": "off" }] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [{ "color": "#bdbdbd" }] }, { "featureType": "administrative.neighborhood", "stylers": [{ "visibility": "off" }] }, { "featureType": "poi", "elementType": "geometry", "stylers": [{ "color": "#eeeeee" }] }, { "featureType": "poi", "elementType": "labels.text", "stylers": [{ "visibility": "off" }] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [{ "color": "#757575" }] }, { "featureType": "poi.business", "stylers": [{ "visibility": "off" }] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [{ "color": "#e5e5e5" }] }, { "featureType": "poi.park", "elementType": "labels.text", "stylers": [{ "visibility": "off" }] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }] }, { "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }] }, { "featureType": "road", "elementType": "labels", "stylers": [{ "visibility": "off" }] }, { "featureType": "road.arterial", "elementType": "labels", "stylers": [{ "visibility": "off" }] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [{ "color": "#757575" }] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [{ "color": "#e6e6e6" }] }, { "featureType": "road.highway", "elementType": "labels", "stylers": [{ "visibility": "off" }] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }] }, { "featureType": "road.local", "stylers": [{ "visibility": "off" }] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [{ "color": "#e5e5e5" }] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [{ "color": "#eeeeee" }] }, { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#dedede" }] }, { "featureType": "water", "elementType": "labels.text", "stylers": [{ "visibility": "off" }] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [{ "color": "#b3b3b3" }] }];
var gmarkers1 = [];
var markers1 = [];
var map = null;
var infowindow = null;

// Initialize Google Maps InfoWindow when API is loaded
function initInfoWindow() {
    if (typeof google !== 'undefined' && google.maps && !infowindow) {
        infowindow = new google.maps.InfoWindow({
            content: ''
        });
    }
}

// Check if Google Maps is loaded and init InfoWindow
if (typeof google !== 'undefined' && google.maps) {
    initInfoWindow();
}


/**
 * Function to init map
 */

function initialize() {
    if (typeof google === 'undefined' || !google.maps) {
        console.warn('Google Maps API not loaded');
        return;
    }

    var mapCanvas = document.getElementById('map-canvas');
    if (!mapCanvas) {
        console.warn('Map canvas element not found');
        return;
    }

    var center = new google.maps.LatLng(25.2912886, 55.4992062);
    var mapOptions = {
        zoom: 11,
        center: center,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
        styles: stylers,
        clickableIcons: false,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        minZoom: 12,
        maxZoom: 16,
        restriction: {
            latLngBounds: {
                north: 26.4,
                south: 25.1,
                west: 55.0,
                east: 55.8
            },
            strictBounds: false,
        },

    };

    map = new google.maps.Map(mapCanvas, mapOptions);

    // Initialize InfoWindow after map is created
    initInfoWindow();
}

function addMarkers() {
    for (i = 0; i < markers.length; i++) {
        addMarker(markers[i]);
    }
}

/**
 * Function to add marker to map
 */

var openWindow = null;
var allMarkers = [];
var markerIds = 0;

/**
 * Function to filter markers by category
 */

currentType = 'all';
currentYear = 'all';

filterMarkers = function () {
    category = currentType;
    year = currentYear;

    var bounds = new google.maps.LatLngBounds();
    for (i = 0; i < gmarkers1.length; i++) {
        marker = gmarkers1[i];

        // If is same category or category not picked
        if (marker.category == category && marker.year == year) {
            $(marker.pin).addClass('active').css('background-color', $(marker.pin).attr('data-color'));
        }
        else if (marker.category == category && year == 'all') {
            $(marker.pin).addClass('active').css('background-color', $(marker.pin).attr('data-color'));
        }
        else if ('all' == category && marker.year == year) {
            $(marker.pin).addClass('active').css('background-color', $(marker.pin).attr('data-color'));
        }
        else if ('all' == category && year == 'all') {
            $(marker.pin).addClass('active').css('background-color', $(marker.pin).attr('data-color'));
        }
        // Categories don't match
        else {
            $(marker.pin).removeClass('active').css('background-color', '#fff');
        }

        // map.fitBounds(bounds);
    }

    removeAllFocus();
}

// Init map
// initialize();

function vAlign() {
    $('.valign').each(function () {
        $(this).css('margin-top', '-' + ($(this).outerHeight() / 2) + 'px');
        $(this).css('display', 'block');
    })
}
vAlign();

introSkipped = false;

$('#introwrap').on('click', function () {
    $(this).fadeOut();
    $('#intropop').addClass('skipped');

    $('#catpop').addClass('active');
    $('#map-wrap').addClass('active');

    if (map) {
        map.setZoom(11);
    }
    addMarkers();
    alignCatPop();
    $('#timeline').addClass('active');

    resizeMap();
    introSkipped = true;

    $('#boxlinks li a').first().addClass('active');

});

function introwrap_fadeOut() {
    $('#introwrap').fadeOut();
    $('#intropop').addClass('skipped');

    $('#catpop').addClass('active');
    $('#map-wrap').addClass('active');
    if (map) {
        map.setZoom(11);
    }
    addMarkers();
    alignCatPop();
    $('#timeline').addClass('active');

    resizeMap();
    introSkipped = true;

    $('#boxlinks li a').first().addClass('active');

}
$('.btn_close_repo_insid').on('click', function () {
    introwrap_fadeOut();
})

var clickCount = 0;
$('#tab_Map').on('click', function () {
    if (clickCount == 0) {
        initialize();
    }
    clickCount++;
})





$('.catdetail .close').on('click', function () {
    $(this).closest('.catdetail').removeClass('active');
});

currentTypeSlug = '';

function hide_timelineSelect() {
    var timelineSelect = document.querySelectorAll('#timelineSelect')
    timelineSelect.forEach(elee => {
        elee.style.display = "none";
    });
}
// hide_timelineSelect();
// $('.timeline_global').show();
$('#typeSelection a').on('click', function () {

    // hide_timelineSelect();
    // let slug = $(this).attr('data-slug');
    // var timeline_slug = document.getElementsByClassName('timeline_'+slug)[0]
    // $('.timeline_'+slug).show();


    if (!$(this).hasClass('active')) {
        currentType = $(this).attr('data-id');
        currentTypeSlug = $(this).attr('data-slug');
        $('#typeSelection a').css('border-color', '#000');
        $('#typeSelection a').css('color', '#000');

        $('.catdetail').removeClass('active');
        $('#cat-' + currentType).addClass('active');

        $('#catpop li a').removeClass('active');
        // $('#catpop li a').css('background-color','#fff');
        $(this).addClass('active');

        $(this).css('border-color', $(this).attr('data-color'));
        $(this).css('color', $(this).attr('data-color'));

        currentType = $(this).attr('data-id');

        $('.catdetail').removeClass('active');
    } else {
        $('.catdetail').removeClass('active');
        currentType = 'all';
        currentTypeSlug = null;
        $(this).removeClass('active');
        $(this).css('border-color', '#000');
        $(this).css('color', '#000');

        if (currentYear) {
            $('.timeline-only.' + currentYear).addClass('active');
        }

        // hide_timelineSelect()
        // $('.timeline_global').show();
    }


    // currentYear = 'all';
    // $('#timelineSelect li a').removeClass('active');
    filterMarkers();

    if (currentYear != 'all' && currentTypeSlug) {
        if ($('.catdetail.' + currentYear + '.' + currentTypeSlug).length)
            $('.catdetail.' + currentYear + '.' + currentTypeSlug).addClass('active');
    }
    else {
        $('#cat-' + currentType).addClass('active');
    }

    removeAllFocus();
    hideAllInfoWindows();
    resizeMap();

    if (openWindow) {
        openWindow.close();
    }
});

$('#typeSelection a').mouseenter(function () {
    $(this).css('color', $(this).attr('data-color'));
    $(this).css('border-color', $(this).attr('data-color'));
});

$('#typeSelection a').mouseleave(function () {
    if (!$(this).hasClass('active')) {
        $(this).css('color', '#000');
        $(this).css('border-color', '#000');
    }
});

$('#timelineSelect li a').mouseenter(function () {
    currentYear = $(this).attr('data-id');

    $('.yeardetail').removeClass('active');
    // $('#year-'+currentYear).addClass('active');

});

// $('#timelineSelect li a').mouseleave(function(){
//     $('.yeardetail').removeClass('active');
// });

$('#timelineSelect li a').on('click', function () {

    if (!$(this).hasClass('active')) {
        $(this).addClass('active');
        currentYear = $(this).attr('data-id');

        $('#timelineSelect li a').removeClass('active');
        $('.catdetail').removeClass('active');

        $(this).addClass('active');
    }
    else {
        currentYear = 'all';
        $(this).removeClass('active');

        if (currentTypeSlug) {
            tg = $('#typeSelection a[data-slug=' + currentTypeSlug + ']');
            currentType = tg.attr('data-id');

            $('#typeSelection a').css('border-color', '#000');
            $('#typeSelection a').css('color', '#000');

            $('.catdetail').removeClass('active');
            $('#cat-' + currentType).addClass('active');

            $('#catpop li a').removeClass('active');
            tg.addClass('active');

            tg.css('border-color', tg.attr('data-color'));
            tg.css('color', tg.attr('data-color'));

            $('#cat-' + currentType).addClass('active');
        } else {
            $('.catdetail').removeClass('active');
        }
    }

    filterMarkers();

    if (currentYear && currentTypeSlug)
        if ($('.catdetail.' + currentYear + '.' + currentTypeSlug).length)
            $('.catdetail.' + currentYear + '.' + currentTypeSlug).addClass('active');

    if (!currentTypeSlug)
        $('.timeline-only.' + currentYear).addClass('active');

    removeAllFocus();
    hideAllInfoWindows();
    resizeMap();

    if (openWindow) {
        openWindow.close();
    }
});

$('#boxlinks .link').on('click', function () {

    $('#introwrap').trigger('click');
    $('#boxlinks .link').removeClass('active');
    $(this).removeClass('active');
    $('.catdetail.active').removeClass('active');
    $('.page').removeClass('active');

    $('.' + $(this).attr('data-id')).addClass('active');

    $('#boxlinks .link').removeClass('active');
    $(this).addClass('active');

    resizeVideoCopy();

    if ($(this).attr('data-id') != 'home') {
        $('#introwrap').css('opacity', 0);
        $('#intropop').css('opacity', 0);
        $('#timeline').css('opacity', 0);
        $('#typeSelection').css('opacity', 0);
        $('.pin').css('opacity', 0);
    }
    else {
        if (!introSkipped) {
            $('#introwrap').css('opacity', 1);
            $('#intropop').css('opacity', 1);
        }

        $('#timeline').css('opacity', 1);
        $('#typeSelection').css('opacity', 1);
        $('.pin').css('opacity', 1);
    }

    setTimeout(function () {
        $('.owl-carousel').trigger('refresh.owl.carousel');
    }, 200);
});

// Load repository content via AJAX
$('.vid').on('click', function () {
    var repositoryId = $(this).attr('data-id');
    var container = $('#repository-detail-container');
    var contentDiv = $('#repository-detail-content');
    var lang = $('html').attr('lang') || 'en';

    // Show loading state
    container.show().addClass('active');
    contentDiv.html('<div style="text-align:center;padding:50px;"><p>Loading...</p></div>');

    // Fetch repository HTML via AJAX
    $.ajax({
        url: '/research/repository-html/' + repositoryId,
        data: { lang: lang },
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            // Set background color
            if (response.background) {
                container.css('background-color', response.background);
            }

            // Insert HTML content
            contentDiv.html(response.html);

            // Initialize carousels in the loaded content
            if (typeof $.fn.owlCarousel !== 'undefined') {
                contentDiv.find('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    dots: true,
                    items: 1,
                    dotsContainer: contentDiv.find('#owl-dots'),
                    mouseDrag: false,
                    touchDrag: false
                });

                // Setup carousel arrows
                contentDiv.find('.arrows .next').on('click', function () {
                    $(this).closest('.owl-carousel-holder').find('.owl-carousel').trigger('next.owl.carousel');
                });
                contentDiv.find('.arrows .prev').on('click', function () {
                    $(this).closest('.owl-carousel-holder').find('.owl-carousel').trigger('prev.owl.carousel');
                });
            }

            // Initialize video placeholders
            contentDiv.find('.video-placeholder').on('click', function () {
                var videoId = $(this).data('video-id');
                if (videoId) {
                    $(this).html('<iframe src="https://player.vimeo.com/video/' + videoId + '?autoplay=1" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>');
                }
            });

            // Setup back button
            contentDiv.find('.backbutton').on('click', function () {
                container.removeClass('active').hide();
                // Stop any playing videos
                var iframe = container.find('iframe');
                if (iframe.length) {
                    iframe[0].contentWindow.postMessage('{"method":"pause"}', '*');
                }
                // Clear content to free memory
                contentDiv.html('');
            });

            setTimeout(function () {
                resizeVideoCopy();
            }, 300);
        },
        error: function () {
            contentDiv.html('<div style="text-align:center;padding:50px;"><p>Error loading content. Please try again.</p></div>');
        }
    });
});

// Check if owlCarousel is available
if (typeof $.fn.owlCarousel !== 'undefined') {
    owl = $('#building-carousel').owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        items: 1,
        dotsContainer: '#owl-dots',
        mouseDrag: false,
        touchDrag: false
    });

    owl = $('.page-carousel').owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        items: 1,
        dotsContainer: '#owl-dots',
    });
}

$('.owl-dot').each(function () {
    $(this).children('span').text($(this).index() + 1);
});

$('.owl-carousel-holder .arrows .next').click(function () {
    $(this).closest('.owl-carousel-holder').find('.owl-carousel').trigger('next.owl.carousel');
});
// Go to the previous item
$('.owl-carousel-holder .arrows .prev').click(function () {
    // With optional speed parameter
    // Parameters has to be in square bracket '[]'
    $(this).closest('.owl-carousel-holder').find('.owl-carousel').trigger('prev.owl.carousel');
});

owl = $('.news-carousel').owlCarousel({
    loop: false,
    margin: 10,
    dots: true,
    items: 1,
    dotsContainer: '#owl-dots',
});

function resizeVideoCopy() {

    target = $('.content-page.active');

    // if($(window).width()>1100){
    //     // height = target.find('.left').css('width',$('#intropop .pagecontent').width());
    //     // height = target.find('.right').css('width',target.find('.container').width() - $('#intropop .pagecontent').width() - 30);
    // } else {
    //     target.find('.left').css('width','100%');
    // }

    // if($(window).width()>991){

    //     $('.video-pop.active .container').each(function(){
    //         // target = $(this);
    //         // height = target.find('.right-content').height();
    //         // height = height - target.find('h1').height();
    //         // height = height - 80;
    //         // target.find('.copy').css('max-height',height+'px');
    //     });

    //     target = $('#building .container');
    //     height = target.find('.right-content').height();
    //     height = height - $('#building-title').height() - parseInt($('#building-title').css('margin-bottom'));
    //     height = height - $('#showform').height();
    //     height = height - $('#building .backbutton').height() - parseInt($('#building .backbutton').css('margin-top'));
    //     height = height - 40;

    //     if($('.content-page.active').find('.video-pop').length==0){
    //         $(target).find('.copy').css('max-height',height+'px');
    //     }


    //     if($('.video-pop.active').length){
    //         target = $('.video-pop.active');
    //         heading = $('.video-pop.active h1');

    //         if(target){
    //             height = target.find('.right .right-content').height();
    //             height = height - $(target).find('.backbutton').height() - parseInt($(target).find('.backbutton').css('margin-top'));
    //             height = height - $(heading).height() - parseInt($(heading).css('margin-bottom'));
    //             height = height - 20;
    //             height = height + parseInt(target.find('.right.right-content').css('padding-top'));
    //             console.log(height);
    //             $('.video-pop.active').find('.copy').css('max-height',height+'px');
    //         }
    //     }

    //     // target = $('.content-page.active');
    //     // height = target.find('.right-content').height();
    //     // height = height - target.find('.page-heading').first().height() - parseInt(target.find('.page-heading').first().css('margin-bottom'));
    //     // console.log(height);
    //     // $(target).find('.copy').css('max-height',height+'px');
    // }

}

// Back button handler for repository detail (delegated for AJAX content)
$(document).on('click', '#repository-detail-container .backbutton', function () {
    var container = $('#repository-detail-container');
    container.removeClass('active').hide();

    var iframe = container.find('iframe');
    if (iframe.length) {
        iframe[0].contentWindow.postMessage('{"method":"pause"}', '*');
    }

    // Clear content to free memory
    $('#repository-detail-content').html('');
    removeBuildingImages();
});

function removeBuildingImages() {
    console.log('Removing images');
    $('#building-carousel .owl-item').trigger('remove.owl.carousel', 0);
    $('#building-carousel .owl-item').trigger('remove.owl.carousel', 1);
    $('#building-carousel .owl-item').trigger('remove.owl.carousel', 2);
    $('#building-carousel .owl-item').trigger('remove.owl.carousel', 3);
    $('#building-carousel .owl-item').trigger('refresh.owl.carousel');
}

$('#building .backbutton').on('click', function () {
    $('.page').removeClass('active');
    $('#successAlert').hide();

    removeBuildingImages();
});

$('#repositoryFilter').on('change', function () {
    $('.repos').hide();

    if ($(this).val() == 'all')
        $('.repos').show();
    else
        $('.type-' + $(this).val()).show();
});

// $('.repository-type-bt').first().trigger('click');

$('.close-page').on('click', function () {
    $(this).closest('.page').removeClass('active');
});

function CustomMarker(opts) {
    if (typeof google !== 'undefined' && google.maps && this.setValues) {
        this.setValues(opts);
    }
}

// Set up CustomMarker prototype when Google Maps is ready
if (typeof google !== 'undefined' && google.maps && google.maps.OverlayView) {
    CustomMarker.prototype = new google.maps.OverlayView();
}

CustomMarker.prototype.draw = function () {
    var self = this;

    var div = this.div;
    if (!div) {
        div = this.div = $('' +
            '<div data-id="' + this.markerid + '">' +
            '<div class="shadow"></div>' +
            '<div class="pulse"></div>' +
            '<div class="pin-wrap">' +
            '<div class="pin" style="background-color: ' + this.color + '" data-color="' + this.color + '"></div>' +
            '</div>' +
            '</div>' +
            '')[0];

        this.pinWrap = this.div.getElementsByClassName('pin-wrap');
        this.pin = this.div.getElementsByClassName('pin');
        this.pinShadow = this.div.getElementsByClassName('shadow');
        div.style.position = 'absolute';
        div.style.cursor = 'pointer';
        var panes = this.getPanes();
        panes.overlayImage.appendChild(div);

        google.maps.event.addDomListener(div, "click", function (event) {
            google.maps.event.trigger(self, "click", event);
            addMarkerClick();
        });

        google.maps.event.addDomListener(div, "mouseover", function (event) {
            if (openWindow) {
                openWindow.close();
            }

            infowindow[$(this).attr('data-id')].open({
                anchor: allMarkers[$(this).attr('data-id')],
                map,
                shouldFocus: false,
            });

            // map.panTo(gmarkers1[$(this).attr('data-id')].position);

            openWindow = infowindow[$(this).attr('data-id')];
        });

        google.maps.event.addDomListener(div, "mouseleave", function (event) {
            if (openWindow) {
                openWindow.close();
            }
        });
    }
    var point = this.getProjection().fromLatLngToDivPixel(this.position);
    if (point) {
        div.style.left = point.x + 'px';
        div.style.top = point.y + 'px';
    }
};

CustomMarker.prototype.removeFocus = function () {
    dynamics.stop(this.pin);
    dynamics.css(this.pin, {
        'transform': 'none',
        'margin-left': '0',
        'margin-top': '0',
        'z-index': '1',
    });

    dynamics.animate(this.pin, {
        scaleX: 1,
        scaleY: 1,
    }, {
        duration: 800,
        bounciness: 1800,
    });
};

CustomMarker.prototype.Focus = function () {
    dynamics.stop(this.pin);
    dynamics.css(this.pin, {
        'transform': 'none',
        'z-index': '2',
    });

    if (map && gmarkers1[this.markerid]) {
        map.panTo(gmarkers1[this.markerid].position);
    }

    dynamics.animate(this.pin, {
        // scaleX: 2.3,
        // scaleY: 2.3,
    }, {
        duration: 800,
        bounciness: 1800,
    });

    for (const [key, value] of Object.entries(gmarkers1)) {
        if (this.markerid != gmarkers1[key].markerid) {
            gmarkers1[key].removeFocus();
        }
    }
}

function removeAllFocus() {
    for (const [key, value] of Object.entries(gmarkers1)) {
        gmarkers1[key].removeFocus();
    }
}

function hideAllInfoWindows() {
    for (const [key, value] of Object.entries(gmarkers1)) {
        infowindow[key].close();
    }
    removeAllFocus();
}

$(window).on('load', function () {
    // $('#intropop').css('left','0');
    $('#loader').hide();
    alignIntroPop();
});


/*********** HOME SCRIPTS **********************/


function checkBar() {
    if ($(window).outerWidth() < 992) {
        $('#logo').addClass('twoline');
    } else {
        $('#logo').removeClass('twoline');
    }

    $('#logo').fadeIn();
}

checkBar();
$(window).resize(function () {
    setTimeout(function () {
        $('.innerpage h1').css('height', 'auto');
        $('.innerpage .breadcrumbs').css('height', 'auto');
        vAlign();
        alignIntroPop();
        alignCatPop();
    }, 100);
    setTimeout(function () {
        resizeVideoCopy();
    }, 300);

    checkBar();
});




$(document).ready(function () {

    $(".owl-carousel_new").owlCarousel({

        autoPlay: 3000,
        items: 1,
        // itemsDesktop : [1199,3],
        // itemsDesktopSmall : [979,3],
        center: true,
        nav: true,
        loop: true,
        dotsContainer: '#owl-dots',
        /* responsive: {
          600: {
            items: 1
          }
        } */
    });

});

document.querySelector('.page-2 .item').addEventListener('mouseenter', function (ele) {
    console.log(ele);
})


// (function(){
//     $(document).ready(function() {
//         let img_page2_height = document.querySelector('.page-2 img').height;

//             var bottomImg = 0;
//             document.querySelector('.page-2 .simplebar-content-wrapper').onscroll = function(el){
//                 var rect = document.querySelector('.page-2 .simplebar-content-wrapper').getBoundingClientRect(),
//                 scrollTop = document.querySelector('.page-2 .simplebar-content-wrapper').pageYOffset || document.querySelector('.page-2 .simplebar-content-wrapper').scrollTop;
//                 var top= rect.top + scrollTop;
//                 if(scrollTop < 700){
//                     bottomImg=scrollTop;
//                 }
//                 // console.log({top:top,rectTop:rect.top,scrTop:scrollTop});

//                 document.querySelectorAll('.page-2 .item').forEach(element => {
//                     element.style.bottom = `${bottomImg}px`;
//                 });
//             }
//         
//     })
// })();

// (function(){
//     $(document).ready(function() {
//         let img_page2_height = document.querySelector('.page-3 img').height;

//             var bottomImg = 0;
//             document.querySelector('.page-3 .simplebar-content-wrapper').onscroll = function(el){
//                 var rect = document.querySelector('.page-3 .simplebar-content-wrapper').getBoundingClientRect(),
//                 scrollTop = document.querySelector('.page-3 .simplebar-content-wrapper').pageYOffset || document.querySelector('.page-4 .simplebar-content-wrapper').scrollTop;
//                 var top= rect.top + scrollTop;
//                 if(scrollTop < 700){
//                     bottomImg=scrollTop;
//                 }
//                 // console.log({top:top,rectTop:rect.top,scrTop:scrollTop});

//                 document.querySelectorAll('.page-3 .item').forEach(element => {
//                     element.style.bottom = `${bottomImg}px`;
//                 });
//             }
//         
//     })
// })();

// (function(){
//     $(document).ready(function() {
//         let img_page2_height = document.querySelector('.page-4 img').height;

//             var bottomImg = 0;
//             document.querySelector('.page-4 .simplebar-content-wrapper').onscroll = function(el){
//                 var rect = document.querySelector('.page-4 .simplebar-content-wrapper').getBoundingClientRect(),
//                 scrollTop = document.querySelector('.page-4 .simplebar-content-wrapper').pageYOffset || document.querySelector('.page-4 .simplebar-content-wrapper').scrollTop;
//                 var top= rect.top + scrollTop;
//                 if(scrollTop < 700){
//                     bottomImg=scrollTop;
//                 }
//                 // console.log({top:top,rectTop:rect.top,scrTop:scrollTop});

//                 document.querySelectorAll('.page-4 .item').forEach(element => {
//                     element.style.bottom = `${bottomImg}px`;
//                 });
//             }
//         
//     })
// })();











//   document.querySelectorAll('iframe').forEach(function(ele) {
//     ele.addEventListener('click', function(ele){
//         document.querySelector('.layout_iframe_pop iframe').src = ele.src;
//         document.querySelector('.layout_iframe_pop').style.display='block';
//     })
//   });





var closeLayoutBtn = document.querySelector('.close_layout_iframe_pop');
if (closeLayoutBtn) {
    closeLayoutBtn.addEventListener('click', function () {
        var layoutPop = document.querySelector('.layout_iframe_pop');
        if (layoutPop) {
            layoutPop.style.display = 'none';
        }
    });
}


(function () {
    $(document).ready(function () {
        // let dataIframes = document.querySelectorAll('.player')
        // if(dataIframes.length == 0){
        //     dataIframes= document.querySelectorAll('#player')
        // }
        // dataIframes.forEach(function(ele){
        //     ele.addEventListener('click' , function(e){
        //         console.log(ele.baseURI)
        //         document.querySelector('.layout_iframe_pop iframe').src = ele.baseURI;
        //         document.querySelector('.layout_iframe_pop').style.display='block';
        //     })
        // })




    })
})();



function fullWidthIframe(url) {
    var iframe = document.querySelector('#fullWidthIframe');
    var layoutPop = document.querySelector('div.layout_iframe_pop');
    if (iframe) {
        iframe.src = url;
    }
    if (layoutPop) {
        layoutPop.style.display = 'block';
    }
}

// document.body.addEventListener('click', function(){
//     if(document.querySelector('div.layout_iframe_pop').style.display =='block'){
//     document.querySelector('div.layout_iframe_pop').style.display='none';
//     }
// })

// Remove Froala branding (run once on load and use MutationObserver instead of setInterval)
function removeFroalaBranding() {
    document.querySelectorAll('.show-placeholder a').forEach(ele => {
        if (ele.text == "Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.") {
            ele.style.display = "none"
        }
    });
    document.querySelectorAll('#fr-logo, [data-f-id="pbf"]').forEach(ele => {
        ele.remove();
    });
}

// Run once on DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', removeFroalaBranding);
} else {
    removeFroalaBranding();
}

// Use MutationObserver for dynamic content instead of setInterval
var froalaObserver = new MutationObserver(function (mutations) {
    removeFroalaBranding();
});

// Start observing after DOM is ready
$(document).ready(function () {
    froalaObserver.observe(document.body, { childList: true, subtree: true });

    // Stop observing after 10 seconds to save resources
    setTimeout(function () {
        froalaObserver.disconnect();
    }, 10000);
});