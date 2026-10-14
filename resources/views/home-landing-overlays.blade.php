<div class="landing-overlays" aria-hidden="true">
    @foreach ([
        'center_image' => 'center',
        'bottom_left_image' => 'bottom-left',
        'bottom_right_image' => 'bottom-right',
    ] as $field => $position)
        @if ($landingElement->{$field})
            <img class="landing-overlay-image landing-overlay-{{ $position }}"
                src="{{ asset('public/' . $landingElement->{$field}) }}" alt="" loading="eager">
        @endif
    @endforeach
</div>
