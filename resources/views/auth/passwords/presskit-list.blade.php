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

		@inject('pageService', 'App\Services\PageService')

		<div class="container text-center">
			<div class="body-section contents">
				<div class="row" dir="rtl">
					<div class="col-md-6 text-right">
						<h5>{{ $data->title_ar }}</h5>
						<h5 class="light">
							{{
                                $pageService->getArabicDate(
                                    $data->publish_date->format('d'),
                                    intval($data->publish_date->format('m')),
                                    $data->publish_date->format('Y')
                                )
                            }}
						</h5>
						<br/>
						<br/>
						<div class="box-links ar">
							@foreach($data->items as $item)
								<a target="_blank" href="{{ asset('public/'.$item->file->url) }}">{{ $item->title_ar }}</a>
							@endforeach
						</div>
					</div>
					<div class="col-md-6 text-left">
						<h5>{{ $data->title }}</h5>
						<h5 class="light">
							{{ $data->publish_date->format('d F Y') }}
						</h5>
						<br/>
						<br/>
						<div class="box-links en">
							@foreach($data->items as $item)
								@if($item->file->url)
									<a target="_blank" href="{{ asset('public/'.$item->file->url) }}" download="{{ $item->file->original_name }}">{{ $item->title }}</a>
								@else
									<a target="_blank" href="{{ asset('public/'.$item->file->file_name) }}" download="{{ $item->file->original_name }}">{{ $item }}</a>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

