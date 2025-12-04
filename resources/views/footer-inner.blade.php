

	@include('footer')

	@include('search')
	@include('subscribe')

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('public/js/popper.min.js') }}"></script>
    <!--- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
	
	<script src="{{ asset('public/js/main.js') }}"></script>
	<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='MMERGE5';ftypes[5]='text';fnames[6]='MMERGE6';ftypes[6]='dropdown';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
	<!--End mc_embed_signup-->

	@if(\Request::path()=="/")
		<script src="{{ asset('public/js/home.js') }}"></script>
	@else
		<script src="{{ asset('public/js/inner.js') }}"></script>
	@endif

	<script>
        var owl = $('.owl-carousel').owlCarousel({
            loop:true,
            margin:0,
            nav:false,
            items:1,
            dotsContainer:'#owl-dots',
            onChange: function (elem) {
                setTimeout(function(){
                    html = '<span class="imgcap"><span class="en float-left">'+$('.owl-item.active img').attr('data-en')+'</span><span dir="rtl" class="float-right">'+$('.owl-item.active img').attr('data-ar')+'</span></span>';
                    $('#owl-caption').html(html);
                },300);
            },
            onInitialize: function (elem) {
                setTimeout(function(){
                    html = '<span class="imgcap"><span class="en float-left">'+$('.owl-item.active img').attr('data-en')+'</span><span dir="rtl" class="float-right">'+$('.owl-item.active img').attr('data-ar')+'</span></span>';
                    $('#owl-caption').html(html);
                },500);
            }
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

	</script>

    @yield('js')

  </body>
</html>
