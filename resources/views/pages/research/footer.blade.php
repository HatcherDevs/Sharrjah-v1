<div class="modal fade" id="searchModal" style="padding-right: 17px; display: none;z-index: 9999999999" aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body" style="position:relative">
                <form action="https://hatch.test/New-sharjah/new_sharjah-architecture/search" method="post">
                    <input type="hidden" value="4mgradC7sgyff4JSuSkdOiGMse11mcTfbV5qGSkj" name="_token">
                    <input type="text" placeholder="Search" name="keyword">
                    <input type="submit" value="">
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>
<script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('public/js/research.js?v=3.6') }}"></script>
<script>
    $(window).resize(function() {
        setTimeout(function() {
            if ($(window).outerWidth() > 420) {
                toggleSearch();
            }
            if ($(window).outerHeight() < 520) {
                $('#menu .mobile').css('overflow-y', 'scroll');
                $('#menu .mobile').css('height', $(window).outerHeight() - parseInt($('#menu .mobile')
                    .css('margin-top')));
            } else {
                $('#menu .mobile').css('height', 'auto').css('overflow-y', 'hidden');
            }

            resizeMap();
        }, 100);

        $('#menu-bt-close').trigger('click');
    });

    var scrollAnimating = false;

    function verticalAlign() {
        $('.v-content').each(function() {
            $(this).css('margin-top', ('-' + $(this).height() / 2) + 'px');
        });
        $('.v-content.nav-section').each(function() {
            $(this).css('margin-top', '-' + (($(this).height() / 2) + 50) + 'px');
        });
    }


    $(window).on('load', function() {
        $('.img_logo').css('display', 'block')
        $('#header').css('display', 'block')
        $('#loader').hide();

        // Initialize and show modal using Bootstrap 5 API
        var repoModalEl = document.getElementById('RepoModalToggle');
        if (repoModalEl) {
            var repoModal = bootstrap.Modal.getOrCreateInstance(repoModalEl);
            repoModal.show();
        }

        // Initialize Repo_insid_ModalToggle modal
        var repoInsidModalEl = document.getElementById('Repo_insid_ModalToggle');
        if (repoInsidModalEl) {
            bootstrap.Modal.getOrCreateInstance(repoInsidModalEl);
        }

        // Pre-initialize all FullScreenVideoPopup modals to prevent getInstance errors
        document.querySelectorAll('.FullScreenVideoPopup').forEach(function(modalEl) {
            bootstrap.Modal.getOrCreateInstance(modalEl);
        });
    });

    // $(window).on('load',function () {
    //     $('#loader').hide();
    // });
    var swiper = new Swiper(".mySwiper_new", {
        slidesPerView: 1,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        // navigation: {
        //   nextEl: ".swiper-button-next",
        //   prevEl: ".swiper-button-prev"
        // }
    });



    var siteUrl = "{{ url('/') }}";

    $(window).resize(function() {
        setTimeout(function() {
            if ($(window).outerWidth() > 420) {
                toggleSearch();
            }
            if ($(window).outerHeight() < 520) {
                $('#menu .mobile').css('overflow-y', 'scroll');
                $('#menu .mobile').css('height', $(window).outerHeight() - parseInt($('#menu .mobile')
                    .css('margin-top')));
            } else {
                $('#menu .mobile').css('height', 'auto').css('overflow-y', 'hidden');
            }

        }, 100);

        $('#menu-bt-close').trigger('click');
    });

    function verticalAlign() {
        $('.v-content').each(function() {
            $(this).css('margin-top', ('-' + $(this).height() / 2) + 'px');
        });
        $('.v-content.nav-section').each(function() {
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
            }, 500, function() {
                $('#menu ul li ul').addClass('animating');


                setTimeout(function() {
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
            }, 200, function() {});

            verticalAlign();

        }
    }

    $('.mobile .cat').on('click', function(e) {

        if ($(this).closest('a').attr('href') == '#')
            e.preventDefault();

        $('.mobile .cat').hide();
        $(this).show();
        $('#mobile-menu-back').show();
        $(this).closest('li').find('ul').show();
        link = $(this).closest('a').attr('alt');
        $(this).closest('a').attr('href', link);

    });

    $('#mobile-menu-back').on('click', function(e) {

        e.preventDefault();
        $('#menu .mobile ul li ul').hide();
        $('#menu .mobile ul li .cat').show();
        $(this).hide();


        $('#menu .mobile ul li .cat').each(function() {
            $(this).closest('a').attr('href', '#');
        });

    });



    $('#repositoryFilter').on('change', function() {
        $('.repos').hide();
        if ($(this).val() == 'all') {
            $('.repos').show();
        } else {
            $('.type-' + $(this).val()).show();
        }
    });



    // Fix: Use Bootstrap API to close modals properly
    document.querySelectorAll('.FullScreenVideoPopup .btn-close').forEach(ele => {
        ele.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Stop iframe video playback
            document.querySelectorAll('.FullScreenVideoPopup iframe').forEach(iframe => {
                var src = iframe.src;
                iframe.src = '';
                iframe.src = src;
            });

            // Close the modal using Bootstrap API
            var modal = this.closest('.modal');
            if (modal) {
                var modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    // Fallback: manually hide modal
                    $(modal).removeClass('show').css('display', 'none');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            }
        });
    });







    $('.menu-click').on('click', function(e) {
        e.preventDefault();
        showMenu();
    });

    $('#showform').on('click', function() {
        $('#content').hide();
        $('#form').show();
    });

    $('.search-click').on('click', function(e) {

        e.preventDefault();

        $('.search-click').hide();
        if ($(window).outerWidth() > 767) {
            if ($(this).hasClass('active')) {} else {
                if ($('#menu').css('top') != "0px")
                    showMenu();

                $(this).addClass('active');

                if ($('#main-logo').width() + parseInt($('#floating-header').css('padding-left')) + 20 <
                    parseInt($('#menu .auto-height-holder').css('padding-left')))
                    $('#search').width($('#floating-header').width() - parseInt($('#menu .auto-height-holder')
                        .css('padding-left')));
                else
                    $('#search').width($('#floating-header').width() - parseInt($('#main-logo').width()) - 60);

                $('#search').fadeIn().trigger('focus');
                $('#search-submit').show();
            }
        }
    });

    $('.menu-close-click').on('click', function(e) {

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
            }, 500, function() {

                $('.english-nav').css('top', '10%').css('opacity', '0');
                $('.arabic-nav').css('bottom', '10%').css('opacity', '0');

                $('#menu ul li ul').removeClass('animating');
                $('#menu').hide();
            });
        }
    });

    function toggleSearch() {
        if ($(window).outerWidth() < 767) {
            $('a#search-bt').attr('data-bs-toggle', "modal").attr('href', "#searchModal");
        } else {
            $('#search-bt').removeAttr('data-bs-toggle').removeAttr('href');
        }
    }
    toggleSearch();


    // Start Research Form submit 
    $('#researchForm').on('submit', function(e) {
        var form = $(this);
        showLoader();

        e.preventDefault();
        e.stopPropagation();

        data = form.serialize();
        url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response) {
                if (response) {
                    $('#form').hide();
                    $('#successAlert').show();
                    document.getElementById("researchForm").reset();
                }
            },
            statusCode: {},
            complete: function(event, error) {
                hideLoader();
            }
        });
    });
    // End Research Form submit 


    // Start Action btn-close Repo Change Modal Bootstrap
    $('.btn_close_repo').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Clear iframe source
        let iframe = document.querySelector('#RepoModalIframe');
        if (iframe) iframe.src = '';

        // Hide modal using Bootstrap 5 API
        var modalEl = document.getElementById('RepoModalToggle');
        if (modalEl) {
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            } else {
                // Fallback if no instance exists
                $(modalEl).removeClass('show').css('display', 'none');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
        }
    })

    $('.btn_close_repo_insid').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var modalEl = document.getElementById('Repo_insid_ModalToggle');
        if (modalEl) {
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            } else {
                $(modalEl).fadeOut();
            }
        }
    })

    $('#tab_1').on('click', function() {
        setTimeout(() => {
            let check = Array.from(document.querySelector('#offcanvasBottom_Repository').classList)
                .includes('show')
            if (check) {
                var modalEl = document.getElementById('Repo_insid_ModalToggle');
                if (modalEl) {
                    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            }
        }, 400);
    })
    // End Action btn-close Repo Change Modal Bootstrap 

    // End Click in Tabs and show Div Tabs
    // let linksTabs = document.querySelectorAll('#boxlinks a.link')
    // linksTabs.forEach(element => {
    //     element.addEventListener('click', function(){
    //         linksTabs.forEach(ele =>{
    //             ele.classList.remove('active');
    //         })
    //         $('.fade.show').css('display','none');
    //         // $('.fade.show').css('opacity',0);
    //         let checkIsActive = Array.from(this.classList).includes('active');
    //         if(checkIsActive != true){
    //             this.classList.add('active');
    //         }else{
    //             this.classList.remove('active');
    //         }

    //     })
    // });
    // Start Click in Tabs and show Div Tabs

    // setInterval(() => {
    //     const scrollbarVisible = (element) => {
    //         return element.scrollHeight > element.clientHeight;
    //     }
    //     const scrollbar = document.querySelectorAll('.scrollbar')
    //     const scrollbar_intro = document.querySelector('.scrollbar_intro')

    //     scrollbar.forEach(ele =>{
    //         if(scrollbarVisible(ele)){
    //             ele.style.position="relative"
    //             ele.style.right="8px"
    //             ele.style.top="-15px"
    //         }else{
    //             ele.style.right="0px"
    //         }
    //     })

    //     if(scrollbarVisible(scrollbar_intro)){
    //         scrollbar_intro.style.position="relative"
    //         scrollbar_intro.style.right="10px"
    //         scrollbar_intro.style.paddingLeft="25px"
    //         scrollbar_intro.style.top="-15px"
    //     }else{
    //         scrollbar_intro.style.position="relative"
    //         scrollbar_intro.style.right="0px"
    //         scrollbar_intro.style.paddingLeft="15px"
    //         scrollbar_intro.style.top="-15px"
    //     }

    //     let Repo_insid_ModalToggle_modal_body = document.querySelector('.Repo_insid_ModalToggle_modal_body')
    //     if(scrollbarVisible(Repo_insid_ModalToggle_modal_body) != true){
    //         document.querySelector('#Repo_insid_ModalToggle .modal-header').classList.add('pl-2')
    //     }else{
    //         document.querySelector('#Repo_insid_ModalToggle .modal-header').classList.add('pl-0')
    //     }

    // }, 10);

    $('#repositoryFilter').find(":selected").text("Filter by : " + $('#repositoryFilter').find(":selected").text())

    $('#repositoryFilter').on('change', function(e) {

        document.querySelectorAll('#repositoryFilter option').forEach(ele => {
            if (ele.value == "all") {
                ele.innerText = ele.value + ' media'
            } else {
                ele.innerText = ele.value
            }
        })
        $('#repositoryFilter').find(":selected").text("Filter by : " + $('#repositoryFilter').find(":selected")
            .text())

    })

    // document.querySelectorAll('#imgAction').forEach(ele=>{#repositoryFilter
    //         ele.addEventListener('click' , function(e){
    //             console.log(e.target.src);
    //         })
    //     })



    // $('#offcanvasBottom_tab_4').bind('change', function () {
    //     if(!Array.from(document.querySelector('#offcanvasBottom_tab_4').classList).includes('show')){
    //         alert('show offcanvasBottom_tab_4')
    //     }else{
    //         alert('hid offcanvasBottom_tab_4')
    //     }
    // });

    // $('#offcanvasBottom_tab_3').bind('DOMSubtreeModified', function () {
    //     if($('#offcanvasBottom_tab_3').attr('class').includes('show')){
    //         alert('show offcanvasBottom_tab_3')
    //     }else{
    //         alert('hid offcanvasBottom_tab_3')
    //     }
    // });

    // $('#offcanvasBottom_tab_2').bind('DOMSubtreeModified', function () {
    //     if($('#offcanvasBottom_News_and_Event').attr('class').includes('show')){
    //         alert('show offcanvasBottom_News_and_Event')
    //     }else{
    //         alert('hid offcanvasBottom_News_and_Event')
    //     }
    // });





    // Back To Repo
    document.querySelector('.repositories_vid .btn_back_to_repo').addEventListener('click', function() {

        $('#offcanvasBottom_Repository').fadeIn();
        $('#offcanvasBottom_Repository').show();
        document.getElementById('offcanvasBottom_Repository').classList.add('show')
    })

    let cards = document.querySelectorAll('.card')
    cards.forEach(element => {
        element.addEventListener('click', function() {

            $('.fade.show').css('display', 'none');
            // this.classList.add('active');

        })
    });

    setInterval(() => {
        let windowClientHeight = document.documentElement.clientHeight - document.getElementById('header')
            .clientHeight
        $('.repository-tab.offcanvas.offcanvas-bottom').css('height', windowClientHeight + 1)
        $('.repositories_vid').css('height', windowClientHeight)
        let topPostion = document.getElementById('header').clientHeight - document.documentElement
            .clientHeight / 100
        $('.offcanvas.offcanvas-start').css('position', 'fixed')
        let x = 8;
        if ($(window).outerWidth() > 992) {
            x = 7
        } else {
            x = 8.5
        }
        $('.offcanvas.offcanvas-start').css('top', topPostion + x)

        $('.intro_page').css('height', windowClientHeight)


        // Modal Main Page Popup
        // $('#RepoModalToggle').css('height', windowClientHeight)
        // let modalMainPage = document.documentElement.clientHeight-windowClientHeight;
        // $('#RepoModalToggle').css('top', modalMainPage)
    }, 10);
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

    #RepoModalToggle,
    #Repo_insid_ModalToggle {
        background-color: rgba(0, 0, 0, 0.556);
    }

    .ar {
        font-family: 'Cairo' !important;
        font-weight: 700;
        line-height: 1.6rem;
    }

    /* Start btn_back_to_repo */
    .btn_back_to_repo {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.7e%3c/svg%3e") center/1em auto no-repeat !important;
        background-color: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.7e%3c/svg%3e") center/1em auto no-repeat !important;
        width: 30% !important;
        font-weight: bold !important;
        cursor: pointer !important;
        opacity: 1 !important;
        padding: 10px 10px 10px 0px !important;
    }

    .btn_back_to_repo:hover {
        color: blue !important;
        text-decoration: underline !important;
    }

    @media (max-width:600px) {
        .btn_back_to_repo {
            width: 75% !important;
        }
    }

    /* End btn_back_to_repo */

    /*  Start Background Color Pages  */
    #main-wrap {
        background-color: {!! $content['intro']->background !!} !important
    }

    #boxlinks li #tab_Map:hover,
    #boxlinks li #tab_Map.active {
        background-color: {!! $content['tab-1']->background !!} !important;
        {{--  border-color: #{!! $content['tab-1']->background !!}!important;  --}}
    }

    #boxlinks li #tab_1:hover,
    #boxlinks li #tab_1.active,
    #offcanvasBottom_Repository {
        background-color: {!! $content['tab-1']->background !!} !important;
        {{--  border-color: #{!! $content['tab-1']->background !!}!important;  --}}
    }

    #boxlinks li #tab_2:hover,
    #boxlinks li #tab_2.active,
    #offcanvasBottom_News_and_Event {
        background-color: {!! $content['tab-2']->background !!} !important;
        {{--  border-color: {!! $content['tab-2']->background !!}!important;  --}}
    }

    #boxlinks li #tab_3:hover,
    #boxlinks li #tab_3.active,
    #offcanvasBottom_tab_3 {
        background-color: {!! $content['tab-3']->background !!} !important;
        {{--  border-color: {!! $content['tab-3']->background !!}!important;  --}}
    }

    #boxlinks li #tab_4:hover,
    #boxlinks li #tab_4.active,
    #offcanvasBottom_tab_4 {
        background-color: {!! $content['tab-4']->background !!} !important;
        {{--  border-color: {!! $content['tab-4']->background !!}!important;  --}}
    }

    /*  End Background Color Pages  */

    /* Start Slider Animation */
    .repository-tab.offcanvas.offcanvas-bottom {
        height: 85vh;
    }




    /* End Slider Animation */

    /* Start Scrollbar in div */
    .scrollbar {
        overflow: hidden auto;
        width: 100%;
        scrollbar-color: rgb(24, 24, 24) #979797;
        scrollbar-width: thin;
    }

    .scrollbar::-webkit-scrollbar-track,
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        -moz-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        -ms-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        -o-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        -o-border-radius: 10px;
        -border-radius: 10px;
        -webkit-background-color: #979797;
        -moz-background-color: #979797;
        -ms-background-color: #979797;
        -o-background-color: #979797;
        background-color: #979797;
        height: 20px;
    }

    .scrollbar::-webkit-scrollbar,
    ::-webkit-scrollbar {
        -webkit-width: 8px;
        -moz-width: 8px;
        -ms-width: 8px;
        -o-width: 8px;
        width: 8px;
        -webkit-background-color: #F5F5F5;
        -moz-background-color: #F5F5F5;
        -ms-background-color: #F5F5F5;
        -o-background-color: #F5F5F5;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar-thumb,
    ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        -o-border-radius: 10px;
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        -moz-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        -ms-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        -o-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        -webkit-background-color: #000;
        -moz-background-color: #000;
        -ms-background-color: #000;
        -o-background-color: #000;
        background-color: #000;
    }

    body {
        overflow: hidden
    }

    .offcanvas-header {
        /* padding-bottom:0px!important;
        padding-right:0px!important; */
    }

    .modal-dialog-scrollable .modal-content {
        max-height: 70%
    }

    /* Start repositories video */
    .repositories_vid {
        bottom: 0% !important;
        /* left:0!important; */
        width: 100% !important;
        /* height:100%!important; */
    }

    /* End repositories video */

    .card {
        cursor: pointer;
    }

    @media(min-width:1200px) {

        /* .repositories_vid{
            top:15%!important;
        } */
        .FullScreenVideoPopup iframe {
            height: 100%;
        }
    }

    @media(max-width:1200px) {
        /* .repositories_vid{
            top:19%!important;
        } */
    }

    @media(max-width:1100px) {
        /* .repositories_vid{
            top:17.5%!important;
        } */
    }

    .vimeovid#parent_iframe button,
    .vimeovid#parent_iframe iframe {
        width: 101% !important;
        position: absolute !important;
        left: 0 !important;
        bottom: 0 !important;
        top: 0 !important;
        right: 0 !important;
        z-index: 1000 !important;
        height: 100%;
    }


    .vimeovid#parent_iframe button {
        opacity: 0 !important;
    }

    @media only screen and (max-width: 1800px) {
        .vimeovid {
            height: 50vh !important;
        }
    }

    @media only screen and (max-width: 1803px) {
        .vimeovid {
            height: 52vh;
        }
    }

    @media only screen and (min-width: 1803px) {
        .vimeovid {
            height: 55vh;
        }
    }


    /* Start Responsive Header */

    @media(max-width: 991px) {

        #logo.oneline {
            height: 78px;
        }

        #logo.oneline .ar1 {
            height: 17px;
            width: auto;
            top: 11px;
            left: 136px;
        }

        #logo.oneline .ar2 {
            height: 17px;
            width: auto;
            top: 11px;
            left: 71px;
        }

        #logo.oneline .ar3 {
            height: 17px;
            width: auto;
            top: 11px;
            left: 11px;
        }

        #logo.oneline .en1 {
            height: 12px;
            width: auto;
            top: 34px;
            left: 11px;
        }

        #logo.oneline .en2 {
            height: 12px;
            width: auto;
            top: 34px;
            left: 78px;
        }

        #logo.oneline .en3 {
            height: 12px;
            width: auto;
            top: 34px;
            left: 184px;
        }

        #menu .buttons {
            left: 85%;
        }

    }

    @media (max-width: 520px) {
        #floating-header.floating #menu-bt {
            height: 78px;
        }

        #logo.oneline .ar1 {
            height: 17px;
            width: auto;
            top: 11px;
            left: 136px;
        }

        #logo.oneline .ar2 {
            height: 17px;
            width: auto;
            top: 11px;
            left: 71px;
        }

        #logo.oneline .ar3 {
            height: 17px;
            width: auto;
            top: 11px;
            left: 11px;
        }

        #logo.oneline .en1 {
            height: 12px;
            width: auto;
            top: 34px;
            left: 11px;
        }

        #logo.oneline .en2 {
            height: 12px;
            width: auto;
            top: 34px;
            left: 78px;
        }

        #logo.oneline .en3 {
            height: 12px;
            width: auto;
            top: 34px;
            left: 184px;
        }

        #menu .buttons {
            left: 85%;
        }
    }




    #loader {
        background-color: rgba(255, 255, 255, 1);
        background-image: url('{{ url('public/img/research/loader.gif') }}');
        background-position: center;
        background-repeat: no-repeat;
        position: absolute;
        z-index: 9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999;
        width: 100%;
        height: 100%;
        background-size: 75px;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    @media (min-width: 1000px) {
        #menu .v-content {
            top: 62%;
            width: 100% !important;
            left: 10%;
        }

        #menu .buttons {
            left: 93%;
            scale: none !important;
        }
    }

    @media(min-width: 1280px) {
        #menu .v-content {
            top: 60%;
            width: 85% !important;
            left: 20%;
        }
    }

    @media screen and (max-width: 620px) {
        #menu .auto-height-holder {
            padding-left: 5px !important;
        }
    }


    /* Popup Main Page  */
    /* #RepoModalToggle .modal-content{
        scale: 70%;
    } */

    /* @media screen and (min-width: 1000px) {
    #RepoModalToggle{
        z-index:99;
    }
} */
    /* #RepoModalToggle .modal-content{
    height: 53vh;
} */

    /* @media(max-width:900px){
    #RepoModalToggle .modal-content{
        scale: 85%;
        height:49vh !important;
    }
   
    #Repo_insid_ModalToggle .modal-content{
        scale: 80%;
    }
}
@media(max-width:991px){
    #RepoModalToggle .modal-dialog{
        max-width:80%!important;
    }
} */

    /* @media(max-width:850px){
    #RepoModalToggle .modal-dialog{
        max-width:100%!important;
    }
}

@media(max-width:676px){
    #RepoModalToggle .modal-content{
        height:45vh !important;
    }
} */

    /* @media(max-width:600px){
    #RepoModalToggle .modal-content{
        height:40vh !important;
    }
} */



    /* @media(max-width:540px){
    #RepoModalToggle .modal-content{
        height:38vh !important;
    }
    #RepoModalToggle .modal-content{
        scale: 95%;
    }
} */





    /* Start Filter By */
    #repositoryFilter {
        background-color: transparent;
        border: 1.5px solid #000;
        outline: 0px !important;
        border-radius: 15px;
        appearance: none;
        /* width: 100%; */
        padding: 0px 10%;
        box-shadow: 0 0 0 0.2rem rgb(255 193 7 / 0%);
    }

    /* End Filter By */

    .offcanvas {
        z-index: 1053;
    }
</style>
<script>
    setInterval(() => {
        document.querySelectorAll('.show-placeholder a').forEach(ele => {
            if (ele.text ==
                "Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.") {
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



    //   $('#tab_Map').on('click',function(){

    //     var iframe = document.getElementById('researchMap'); // تغيير 'myIframe' إلى اسم الإطار الخاص بك
    //     var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
    //     var iframeElement = iframeDocument.getElementById('building'); // تغيير 'elementInsideIframe' إلى اسم العنصر الذي تريد تحديده


    //     if($('#offcanvasBottom_tab_Map').hasClass('show')){
    //         // console.log(iframeElement , iframeElement.attributes[0].nodeValue == "page active")
    //         if(iframeElement.attributes[0].nodeValue == "page active"){
    //             var iframe = document.getElementById('researchMap'); // تغيير 'myIframe' إلى اسم الإطار الخاص بك
    //             var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
    //             var iframeElement = iframeDocument.getElementById('building');
    //             $(iframeElement).removeClass('active');

    //             $('#offcanvasBottom_tab_Map').addClass('show')
    //         }else{
    //             $('#offcanvasBottom_tab_Map').removeClass('show')
    //         }
    //     }else{
    //         $('#offcanvasBottom_tab_Map').addClass('show')
    //     }
    // });

    // var boxlinks = document.querySelectorAll('#boxlinks li').length
    // for (let i = 1; i <= 4; i++) {
    //     $('#tab_'+i).on('click',function(e){
    //         $('#offcanvasBottom_tab_Map').removeClass('show');
    //         for (let x = 1; x <= 4; x++) {
    //             console.log($('#tab_'+x));
    //             $('#tab_'+x).removeClass('show');
    //         }
    //         $(e.target.dataset.bsTarget).addClass('show')
    //     })
    // }
    /*    
    (function(){
        var iframe = document.getElementById('researchMap');
        if (iframe) iframe.src = '{{ route('researchMap') }}';
    })();

    */
    window.onload = function() {
        var iframe = document.getElementById('researchMap');
        if (iframe) iframe.src = '{{ route('researchMap') }}';
    };
</script>




<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChdoqnSnfKQL3byDY_Ju6MvoUD0Xds3Tk&callback=Function.prototype">
</script>
<script type="text/javascript"
    src="https://github.com/michaelvillar/dynamics.js/releases/download/0.0.8/dynamics.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script type="text/javascript">
    setInterval(() => {
        document.querySelectorAll('.show-placeholder a').forEach(ele => {
            if (ele.text ==
                "Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.") {
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
</script>
<script type="text/javascript">
    function showLoader() {
        // $('#loader').fadeIn();
    }

    function hideLoader() {
        $('#loader').fadeOut();
    }

    $('#mapModalCenter').addClass('show d-block');

    $('#mapModalCenter #close').on('click', function() {
        $('#mapModalCenter').removeClass('show d-block');
        $('#mapModalCenter').addClass('d-none');
        $('#mapModalCenter').removeAttr('style');
        $('#mapModalCenter').css('display', 'none !important');
    })

    var siteUrl = "{{ url('/') }}";

    $(window).resize(function() {
        setTimeout(function() {
            if ($(window).outerWidth() > 420) {
                toggleSearch();
            }
            if ($(window).outerHeight() < 520) {
                $('#menu .mobile').css('overflow-y', 'scroll');
                $('#menu .mobile').css('height', $(window).outerHeight() - parseInt($('#menu .mobile')
                    .css('margin-top')));
            } else {
                $('#menu .mobile').css('height', 'auto').css('overflow-y', 'hidden');
            }

            resizeMap();
        }, 100);

        $('#menu-bt-close').trigger('click');
    });

    var scrollAnimating = false;

    function verticalAlign() {
        $('.v-content').each(function() {
            $(this).css('margin-top', ('-' + $(this).height() / 2) + 'px');
        });
        $('.v-content.nav-section').each(function() {
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
            }, 500, function() {
                $('#menu ul li ul').addClass('animating');


                setTimeout(function() {
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
            }, 200, function() {});

            verticalAlign();

        }
    }

    $('.mobile .cat').on('click', function(e) {

        if ($(this).closest('a').attr('href') == '#')
            e.preventDefault();

        $('.mobile .cat').hide();
        $(this).show();
        $('#mobile-menu-back').show();
        $(this).closest('li').find('ul').show();
        link = $(this).closest('a').attr('alt');
        $(this).closest('a').attr('href', link);

    });

    $('#mobile-menu-back').on('click', function(e) {

        e.preventDefault();
        $('#menu .mobile ul li ul').hide();
        $('#menu .mobile ul li .cat').show();
        $(this).hide();


        $('#menu .mobile ul li .cat').each(function() {
            $(this).closest('a').attr('href', '#');
        });

    });

    $('.menu-click').on('click', function(e) {
        e.preventDefault();
        showMenu();
    });

    $('#showform').on('click', function() {
        $('#content').hide();
        $('#form').show();
    });

    $('.search-click').on('click', function(e) {

        e.preventDefault();

        $('.search-click').hide();
        if ($(window).outerWidth() > 767) {
            if ($(this).hasClass('active')) {} else {
                if ($('#menu').css('top') != "0px")
                    showMenu();

                $(this).addClass('active');

                if ($('#main-logo').width() + parseInt($('#floating-header').css('padding-left')) + 20 <
                    parseInt($('#menu .auto-height-holder').css('padding-left')))
                    $('#search').width($('#floating-header').width() - parseInt($('#menu .auto-height-holder')
                        .css('padding-left')));
                else
                    $('#search').width($('#floating-header').width() - parseInt($('#main-logo').width()) - 60);

                $('#search').fadeIn().trigger('focus');
                $('#search-submit').show();
            }
        }
    });

    $('.menu-close-click').on('click', function(e) {

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
            }, 500, function() {

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

    // Our markers
    markers = [
        @foreach ($data as $item)
            ['{{ $item->id }}', '{{ $lang == 'ar' ? $item->title_ar : $item->title }}', {{ $item->lat }},
                {{ $item->lng }}, '{{ $item->research_type_id }}',
                '{{ asset('public/img/research') }}/m{{ $item->research_type_id }}.png', '{{ $item->year }}',
                "{{ strip_tags(json_encode($item->content)) }}", '{{ $item->color }}', '{{ $item->slug }}',
                '{{ $item->thumb }}'
            ],
        @endforeach
    ];

    // Our type and timeline details

    typeTimeDetails = [];
    @foreach ($types as $type)
        row = {
            'id': '{{ $type['id'] }}',
            @foreach ($timelines as $timeline)
                '{{ $timeline }}': `{{ $type[$timeline] }}`,
            @endforeach
        };
        typeTimeDetails.push(row);
    @endforeach

    document.getElementById('introwrap').addEventListener('mousemove', function(e) {
        let body = document.getElementById('introwrap');
        let circle = document.getElementById('clickstart');
        let left = e.offsetX;
        let top = e.offsetY;
        circle.style.left = left + 30 + 'px';
        circle.style.top = (top - 60) + 'px';
    });

    function addMarkerClick() {
        $('.show-building').on('click', function() {
            showLoader();
            getCaseStudy($(this).attr('data-id'))
        });
    }

    function getCaseStudy(id) {
        showLoader();

        for (x = 1; x < $('#building-carousel .owl-item').length; x++)
            $('#building-carousel .owl-item').trigger('remove.owl.carousel', x);

        $('#building-carousel .owl-item').trigger('refresh.owl.carousel');

        $.ajax({
            type: "GET",
            url: siteUrl + '/research/get-data/' + id,
            success: function(response) {
                data = JSON.parse(response);

                @if ($lang == 'ar')
                    $('#building-title').html(data.title_ar);
                    $('#building-content').html(data.content_ar);
                @else
                    $('#building-title').html(data.title);
                    $('#building-content').html(data.content);
                @endif
                $('#researchId').val(data.id);

                $('#building-carousel').trigger('add.owl.carousel', ['<div class="item"><img src="' + data
                    .slides + '" width="100%"> </div>'
                ]);

                if (data.gallery.length) {
                    Object.keys(data.gallery).forEach(key => {
                        console.log(data.gallery[key].image);
                        $('#building-carousel').trigger('add.owl.carousel', [
                            '<div class="item"><img src="' + siteUrl + '/public/' + data
                            .gallery[key].image + '" width="100%"> </div>'
                        ]);
                    });
                    $('#building .arrows').show();
                } else {
                    $('#building .arrows').hide();
                }

                $('#content').show();
                $('#form').hide();
            },
            statusCode: {
                401: function() {}
            },
            complete: function(event, error) {
                hideLoader();
                $('#building').addClass('active');
                $('#building-carousel').trigger('refresh.owl.carousel');
                setTimeout(function() {
                    resizeVideoCopy();
                }, 300);
            }
        });
    }

    $('#researchForm').on('submit', function(e) {
        var form = $(this);
        showLoader();

        e.preventDefault();
        e.stopPropagation();

        data = form.serialize();
        url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response) {
                if (response) {
                    $('#form').hide();
                    $('#successAlert').show();
                    document.getElementById("researchForm").reset();
                }
            },
            statusCode: {},
            complete: function(event, error) {
                hideLoader();
            }
        });
    });

    function addMarker(marker) {
        var markerid = marker[0];
        var category = marker[4];
        var title = marker[1];
        var pos = new google.maps.LatLng(marker[2], marker[3]);
        var content = marker[1];
        var icon = marker[5];
        var year = marker[6];
        var details = marker[7];
        var color = marker[8];
        var slug = marker[9];
        var thumb = marker[10];

        var contentString = '<div class="mapcontent">' +
            '<div class="siteNotice">' +
            '</div>' +
            '<a href="#" data-id="' + slug + '" class="show-building"><img src="' + thumb +
            '" class="marker-thumb" width="200"></a></div>' +
            {{-- '<a href="#" data-id="'+slug+'" class="show-building"><img src="'+thumb+'" class="marker-thumb" width="200">{{ $lang == 'ar'  ? 'اضغط للعرض ' : 'Click to view' }} '+title+'</a></div>' +? --}}
        // "<button>Read More</button>" +
        "" +
        "</div></div>";

        allMarkers[markerid] = new CustomMarker({
            position: pos,
            color: color,
            category: category,
            markerid: markerid,
            year: year,
            map: map,
        });

        // google.maps.event.addListener(allMarkers[markerid], 'click', function(e) {
        //     allMarkers[markerid].Focus();
        // });

        gmarkers1.push(allMarkers[markerid]);

        infowindow[markerid] = new google.maps.InfoWindow({
            content: contentString,
            disableAutoPan: false
        });

        infowindow[markerid].addListener('closeclick', () => {
            removeAllFocus();
        });

        allMarkers[markerid].addListener("click", (e) => {
            getCaseStudy(markerid);
            //
            // if(openWindow){
            //     openWindow.close();
            // }
            //
            // infowindow[markerid].open({
            //     anchor: allMarkers[markerid],
            //     map,
            //     shouldFocus: false,
            // });
            //
            // openWindow = infowindow[markerid];
        });

        markerIds++;
    }

    function resizeMap() {
        setTimeout(function() {
            $('#map-canvas').css('height', $(window).height());
            $('#map-wrap').css('height', '100vh');
            $('#timeline').css('height', $('#map-canvas').height());
            $('#pages').css('height', $('#map-canvas').height());

            @if ($lang == 'ar')
                $('#timeline.active').css('left', '85%');
            @else
                $('#timeline.active').css('left', '85%');
            @endif

            boxWidth = 0;
            counts = 1;

            if ($(window).width() > 1100) {
                // $('#boxlinks li').each(function() {
                //     if (counts < $('#boxlinks li').length)
                //         boxWidth += $(this).width();
                //     counts++;
                // });

                $('.catdetail').css('width', '40%');

                @if ($lang == 'ar')
                    $('.catdetail').css('left', '30%');
                @else
                    $('.catdetail').css('left', '30%');
                @endif

            } else if ($(window).width() <= 1100 && $(window).width() > 640) {

                boxWidth = $('#boxlinks').width();

                $('.catdetail').css('width', '50%');
                // $('#intropop').css('width',boxWidth);

                $('.catdetail').css('left', '25%');
                // $('#intropop').css('left',$('#boxlinks').offset().left);

            } else {
                boxWidth = $('#logo').outerWidth();
                console.log(boxWidth);
                $('.catdetail').css('width', '70%');
                // $('#intropop').css('width',boxWidth);

                $('.catdetail').css('left', '15%');
                // $('#intropop').css('left',$('#logo').first().offset().left);
            }

            // $('.catdetail.active').css('bottom',($(window).height() - ($('#timeline li').last().offset().top + $('#timelineSelect li').last().outerHeight())));
            @if ($content['map-page-title']->background == 1)
                $('.catdetail').css('display', 'block');
            @elseif ($content['map-page-title']->background == 0)
                $('.catdetail').css('display', 'none');
            @endif



        }, 300);
    }
    resizeMap();

    function alignIntroPop() {

        if ($(window).width() > 1100) {
            @if ($lang == 'ar')
                $('#intropop').css('right', ($(window).width() - ($('#bottommenu').outerWidth() + $('#bottommenu')
                    .offset().left)) + 'px');
                $('.pagepop').css('right', ($(window).width() - ($('#bottommenu').outerWidth() + $('#bottommenu')
                    .offset().left)) + 'px');
            @else
                $('#intropop').css('left', $('#bottommenu').offset().left + 'px');
                $('.pagepop').css('left', $('#bottommenu').offset().left + 'px');
            @endif
        } else {
            $('#intropop').css('right', 'auto');
            $('.pagepop').css('right', 'auto');
        }
    }
    alignIntroPop();

    function alignCatPop() {

        if ($(window).width() > 1100) {
            @if ($lang == 'ar')
                $('#catpop.active').css('right', ($(window).width() - ($('#bottommenu').offset().left + $('#bottommenu')
                    .outerWidth())) + 'px');
            @else
                $('#catpop.active').css('left', $('#bottommenu').offset().left + 'px');
            @endif
        } else {
            @if ($lang == 'ar')
                $('#catpop.active').css('right', '0');
            @else
                $('#catpop.active').css('left', $('#bottommenu').offset().left + 'px');
            @endif
        }
    }
    alignCatPop();

    // $('.audiofy').on('click',function(){
    //     var msg = new SpeechSynthesisUtterance($(this).text());
    //     window.speechSynthesis.speak(msg);
    // });
</script>
<script src="{{ asset('public/js/research.js?v=3.7') }}"></script>

<style>
    .scrollwrap {
        padding-right: 13px;
    }
</style>

<?php
if(isset($_GET['article'])){
?>
<script>
    resizeVideoCopy();
</script>
<?php
}
?>
<script>
    // #offcanvasBottom_tab_Map
    $(document).ready(function() {
        $('#tab_Map').click(function() {
            $('#offcanvasBottom_tab_Map').css('transform', 'translateY(0%)');
        });
    });
</script>
<style>
    .page {
        background-color: #fff !important;
    }

    @media(max-wdith:1000px) {
        #offcanvasBottom_tab_Map #mapModalCenter .modal-dialog {
            margin-left: 0rem !important;
        }

        #mapModalCenter .modal-content {
            height: 50vh !important;
        }
    }
</style>
