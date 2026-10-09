{{-- Inline SVG icons (no icon-font dependency). Usage: @include('partials.icon', ['name' => 'globe']) --}}
@php
    $paths = [
        'globe'   => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.4 2.5 3.6 5.5 3.6 9s-1.2 6.5-3.6 9c-2.4-2.5-3.6-5.5-3.6-9S9.6 5.5 12 3z"/>',
        'logout'  => '<path d="M9 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h4"/><path d="M16 8l4 4-4 4"/><path d="M20 12H9"/>',
        'chevron' => '<path d="M6 9l6 6 6-6"/>',
        'check'   => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
    ];
@endphp
<svg class="icon{{ ($flip ?? false) ? ' icon_flip' : '' }}" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">{!! $paths[$name] ?? '' !!}</svg>
