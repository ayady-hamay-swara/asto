{{-- Pass ['tabs' => ['students' => 'خوێندکار', ...], 'tab' => 'students']. Each area decides which tabs it shows. --}}
<nav class="tabs">
    <div class="tab_name">
        @foreach ($tabs as $key => $fallback)
            <a href="{{ request()->fullUrlWithQuery(['tab' => $key]) }}"
               class="tab{{ $tab === $key ? ' is_active' : '' }}"
               @if ($tab === $key) aria-current="page" @endif
               data-i18n="tab_{{ $key }}">{{ $fallback }}</a>
        @endforeach
    </div>
</nav>
