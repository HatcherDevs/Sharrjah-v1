<?php
$breadcrumbs = isset($page) ? $page->breadcrumbs : null;
$count = is_array($breadcrumbs) ? count($breadcrumbs) : 0;
?>
@if ($count)
    @foreach ($breadcrumbs as $link)
        @if ($loop->first)
            <a href="{{ url($link['link']) }}">{{ $link['name'] }}</a>
        @else
            <a href="{{ url('pages' . $link['link']) }}">{{ $link['name'] }}</a>
        @endif

        @if (!$loop->last)
            >
        @else
            @if (isset($post) && $post)
                > <a href="">{{ $post->title }}</a>
            @endif
        @endif
    @endforeach
@else
    <a href="{{ url('/') }}">Home</a>
@endif
