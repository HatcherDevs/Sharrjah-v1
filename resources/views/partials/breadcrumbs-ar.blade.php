<?php
$breadcrumbs = $page->breadcrumbs;
$count = is_array($breadcrumbs) ? count($breadcrumbs) : 0;
?>
@if ($count)
    @foreach ($page->breadcrumbs as $link)
        @if ($loop->first)
            <a href="{{ url($link['link']) }}">{{ $link['name_ar'] }}</a>
        @else
            <a href="{{ url('pages' . $link['link']) }}">{{ $link['name_ar'] }}</a>
        @endif

        @if (!$loop->last)
            >
        @else
            @if ($post)
                > <a href="">{{ $post->title_ar }}</a>
            @endif
        @endif
    @endforeach
@else
    <a href="{{ url('/') }}">Home</a>
@endif
