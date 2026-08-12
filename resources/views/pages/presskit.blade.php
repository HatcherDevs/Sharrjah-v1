@extends('pages.master')

@section('content')
	<div class="innerpage">
		<div class="container text-center">
			<div class="body-section contents">
				<div class="row" dir="rtl">
					<div class="col-md-6 text-right">
						<div class="breadcrumbs">
							@include('partials.breadcrumbs-ar')
						</div>
						<h1>{!!  $page->name_ar !!}</h1>
						{!! $page->content_ar !!}
					</div>
					<div class="col-md-6 text-left">
						<div class="breadcrumbs en">
							@include('partials.breadcrumbs')
						</div>
						<h1>{!!  $page->name !!}</h1>
						{!! $page->content !!}
					</div>
				</div>
			</div>
		</div>


	</div>
@endsection
