<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title data-i18n="@yield('title_key')">@yield('title_text')</title>

    {{-- Set language + direction before first paint so there is no flash --}}
    <script>
        (function () {
            try {
                var map = { ku: ['ckb', 'rtl'], en: ['en', 'ltr'], ar: ['ar', 'rtl'] };
                var m = map[localStorage.getItem('asto_lang')] || map.ku;
                document.documentElement.lang = m[0];
                document.documentElement.dir = m[1];
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600&family=Poppins:ital,wght@0,400;0,500;0,600;1,600&display=swap">

    {{-- Load order: design-system → page css --}}
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    @stack('styles')
</head>
<body>
    <div class="container">
        <main class="main_content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/languages.js') }}"></script>
    <script src="{{ asset('js/ui.js') }}"></script>
    @stack('scripts')
</body>
</html>
