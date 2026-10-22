{{-- The only chrome on the page: language select + logout.
     Pass ['showLogout' => false] on screens where nobody is signed in (login). --}}
@php $showLogout = $showLogout ?? true; @endphp
<div class="page_actions">
    <div class="lang_switch">
        <button type="button" id="lang_btn" class="chip_btn" aria-haspopup="menu" aria-expanded="false" aria-controls="lang_menu">
            @include('partials.icon', ['name' => 'globe'])
            <span class="sr_only" data-i18n="lang_label">زمان</span>
            <span id="lang_current">کوردی</span>
            @include('partials.icon', ['name' => 'chevron'])
        </button>
        <ul id="lang_menu" class="lang_menu" role="menu" hidden>
            @foreach ([['ku', 'ckb', 'کوردی'], ['en', 'en', 'English']] as [$code, $htmlLang, $name])
                <li role="none">
                    <button type="button" class="lang_option" role="menuitemradio"
                            aria-checked="{{ $code === 'ku' ? 'true' : 'false' }}"
                            data-lang="{{ $code }}" lang="{{ $htmlLang }}">
                        <span>{{ $name }}</span>
                        @include('partials.icon', ['name' => 'check'])
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    @if ($showLogout)
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit" class="chip_btn">
                @include('partials.icon', ['name' => 'logout', 'flip' => true])
                <span data-i18n="logout">چوونەدەرەوە</span>
            </button>
        </form>
    @endif
</div>
