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

		<div class="container text-center">
			<div class="body-section contents">
				<div class="row" dir="rtl">

					@if (Session::has('error'))
						<div class="col-md-12 grid-margin stretch-card" dir="ltr">
							<div class="alert alert-info">{{ Session::get('error') }}</div>
						</div>
					@endif
					<div class="col-md-6 text-right">
						<h5>دخول الصحافة</h5>
						<span class="space40"></span>
						<form action="{{ url('pages/media/press-kit/login') }}" method="post">
							<input type="hidden" value="{!! csrf_token() !!}" name="_token">
							<label>اسم المستخدم</label><br>
							<input type="text" name="username"><br>
							<label>كلمة المرور</label><br>
							<input type="password" name="password"><br>
							<input type="submit" class="ar" value="إرسال">
						</form>
					</div>
					<div class="col-md-6 text-left">
						<h5>Press Access</h5>
						<span class="space40"></span>
						<form action="{{ url('pages/media/press-kit/login') }}" method="post">
							<input type="hidden" value="{!! csrf_token() !!}" name="_token">
							<label>Username</label><br>
							<input type="text" name="username"><br>
							<label>Password</label><br>
							<input type="password" name="password"><br>
							<input type="submit" class="en" value="Submit">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
