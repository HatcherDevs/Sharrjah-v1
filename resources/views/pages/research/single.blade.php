@include('pages.research.header')

<style>
</style>


<div id="main-wrap" class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div id="content">
                    <div class="pull-left">
                        <h3 class="page-heading">{{ $data->title }}</h3>
                        {!! $data->content !!}
                    </div>
                    <br/>
                    <br/>
                    <a href="#" id="showform"><b>Contribute with your story <br/>
                            or data related to this building</b></a>
                </div>
                <div id="form">
                    <form>
                        <label>Email:</label>
                        <input type="text" class="form-control">
                        <label>Message:</label>
                        <textarea class="form-control">

                        </textarea>

                        <input type="submit" value="Submit" class="submit">
                    </form>
                </div>

                <button class="backbutton">Go back to map</button>
            </div>
            <div class="col-lg-8 col-md-12">

                <div class="owl-carousel-holder" dir="ltr">
                    <div class="arrows">
                        <button class="prev float-left"></button>
                        <button class="next float-right"></button>
                    </div>
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <img src="{{ asset('public/img/research/video-placeholder.jpg') }}" width="100%">
                        </div>
                        <div class="item">
                            <img src="{{ asset('public/img/research/video-placeholder.jpg') }}" width="100%">
                        </div>
                        <div class="item">
                            <img src="{{ asset('public/img/research/video-placeholder.jpg') }}" width="100%">
                        </div>
                    </div>
                    <div id="owl-dots"></div>
                </div>

            </div>
        </div>
    </div>
</div>
{{--<div id="cursor"></div>--}}
{{--<div id="cursorFollow"></div>--}}

<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChdoqnSnfKQL3byDY_Ju6MvoUD0Xds3Tk"></script>
<script type="text/javascript" src="https://github.com/michaelvillar/dynamics.js/releases/download/0.0.8/dynamics.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript">

    $('#showform').on('click', function(){
        $('#content').hide();
        $('#form').show();
    });

    var owl = $('.owl-carousel').owlCarousel({
        loop:false,
        margin:10,
        dots:true,
        items:1,
        dotsContainer:'#owl-dots',
        // onChange: function (elem) {
        //     setTimeout(function(){
        //         html = '<span class="imgcap"><span class="en float-left">'+$('.owl-item.active img').attr('data-en')+'</span><span dir="rtl" class="ar float-right">'+$('.owl-item.active img').attr('data-ar')+'</span></span>';
        //         $('#owl-caption').html(html);
        //     },300);
        // },
        // onInitialize: function (elem) {
        //     setTimeout(function(){
        //         html = '<span class="imgcap"><span class="en float-left">'+$('.owl-item.active img').attr('data-en')+'</span><span dir="rtl" class="ar float-right">'+$('.owl-item.active img').attr('data-ar')+'</span></span>';
        //         $('#owl-caption').html(html);
        //     },500);
        // }
    });

    $('.owl-dot').each(function(){
        $(this).children('span').text($(this).index()+1);
    });

    $('.owl-carousel-holder .arrows .next').click(function() {
        owl.trigger('next.owl.carousel');
    });
    // Go to the previous item
    $('.owl-carousel-holder .arrows .prev').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owl.trigger('prev.owl.carousel');
    });

    $(window).resize(function(){
        setTimeout(function(){
            if($(window).outerWidth()>420){
                toggleSearch();
            }
            if($(window).outerHeight()<520){
                $('#menu .mobile').css('overflow-y','scroll');
                $('#menu .mobile').css('height',$(window).outerHeight()-parseInt($('#menu .mobile').css('margin-top')));
            }
            else {
                $('#menu .mobile').css('height','auto').css('overflow-y','hidden');
            }

        },100);

        $('#menu-bt-close').trigger('click');
    });

    var scrollAnimating = false;

    function verticalAlign(){
        $('.v-content').each(function(){
            $(this).css('margin-top',('-'+$(this).height()/2)+'px');
        });
        $('.v-content.nav-section').each(function(){
            $(this).css('margin-top','-'+(($(this).height()/2) + 50)+'px');
        });
    }


    function showMenu(){
        if(!$('#menu ul li ul').hasClass('animating')){

            $('.auto-height').css('height',parseInt($(window).outerHeight())+'px');
            $('.auto-height-holder').css('height',(parseInt($(window).outerHeight()))+'px');

            $('#menu').show();
            $('#menu-bt').hide();
            $('body').addClass('disableScroll');
            $('#search-bt').show().css('display','block');
            $('#menu-bt-close').show().css('display','block');
            $('#menu ul li ul').css('margin-top','-100%');

            $('#menu .v-content').animate({
                opacity: 1
            },300);

            $('#menu .v-content').css('width',$('#menu .auto-height-holder').width()-30);

            $('#menu').animate({
                top: "0",
                right: "0",
            }, 500, function() {
                $('#menu ul li ul').addClass('animating');


                setTimeout(function(){
                    $('.english-nav').animate({
                        top:'105%',
                        opacity: 1
                    },400);
                    $('.arabic-nav').animate({
                        bottom:'105%',
                        opacity: 1
                    },400);
                },100);

                $('#menu ul li ul').removeClass('animating');

            });

            $('#menu ul li ul').animate({
                marginTop: "0"
            }, 200, function() {
            });

            verticalAlign();

        }
    }

    $('.mobile .cat').on('click', function(e){

        if($(this).closest('a').attr('href')=='#')
            e.preventDefault();

        $('.mobile .cat').hide();
        $(this).show();
        $('#mobile-menu-back').show();
        $(this).closest('li').find('ul').show();
        link = $(this).closest('a').attr('alt');
        $(this).closest('a').attr('href',link);

    });

    $('#mobile-menu-back').on('click', function(e){

        e.preventDefault();
        $('#menu .mobile ul li ul').hide();
        $('#menu .mobile ul li .cat').show();
        $(this).hide();


        $('#menu .mobile ul li .cat').each(function(){
            $(this).closest('a').attr('href','#');
        });

    });

    $('.menu-click').on('click', function(e){
        e.preventDefault();
        showMenu();
    });

    $('.search-click').on('click', function(e){

        e.preventDefault();

        $('.search-click').hide();
        if($(window).outerWidth()>767){
            if($(this).hasClass('active')){
            }
            else{
                if($('#menu').css('top')!="0px")
                    showMenu();

                $(this).addClass('active');

                if($('#main-logo').width() + parseInt($('#floating-header').css('padding-left'))+20 < parseInt($('#menu .auto-height-holder').css('padding-left')))
                    $('#search').width($('#floating-header').width()-parseInt($('#menu .auto-height-holder').css('padding-left')));
                else
                    $('#search').width($('#floating-header').width()-parseInt($('#main-logo').width())-60);

                $('#search').fadeIn().trigger('focus');
                $('#search-submit').show();
            }
        }
    });

    $('.menu-close-click').on('click', function(e){

        e.preventDefault();
        if(!$('#menu ul li ul').hasClass('animating')){

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
            },100);

            $('#menu').animate({
                top: "-105%",
                right: "-205%",
            }, 500, function() {

                $('.english-nav').css('top','10%').css('opacity','0');
                $('.arabic-nav').css('bottom','10%').css('opacity','0');

                $('#menu ul li ul').removeClass('animating');
                $('#menu').hide();
            });
        }
    });

    function toggleSearch(){
        if($(window).outerWidth()<767){
            $('#search-bt').attr('data-toggle',"modal").attr('data-target',"#searchModal");
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

    /*********** HOME SCRIPTS **********************/


    function checkBar(){
        if($(window).outerWidth()<992){
            $('#logo').addClass('twoline');
        } else {
            $('#logo').removeClass('twoline');
        }

        $('#logo').fadeIn();
    }

    checkBar();
    $(window).resize(function(){
        setTimeout(function(){
            $('.innerpage h1').css('height','auto');
            $('.innerpage .breadcrumbs').css('height','auto');
        },100);

        checkBar();
    });

    $(window).on('load',function(){
        $('.backbutton').css('display','block');
    });

</script>
</body>
</html>



