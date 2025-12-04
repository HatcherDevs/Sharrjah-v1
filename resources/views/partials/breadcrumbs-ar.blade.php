
<?php
$count = count($page->breadcrumbs);
$loop = 0;
?>
@if($count)
    @foreach($page->breadcrumbs as $link)
        <?php $loop++; ?>

        @if ($loop==1)
            <a href="{{ url($link['link']) }}">{{ $link['name_ar'] }}</a>
        @else
            <a href="{{ url('pages'.$link['link']) }}">{{ $link['name_ar'] }}</a>
        @endif

        @if ($count!=$loop)
            >
        @else
            @if($post)
                > <a href="">{{ $post->title_ar }}</a>
            @endif
        @endif
    @endforeach
@else
    <a href="{{ url('/') }}">Home</a>
@endif