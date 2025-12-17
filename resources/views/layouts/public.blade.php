<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'ĐBDK2T - Cửa hàng điện tử & công nghệ')</title>

    {{-- Fontawesome (index đang dùng) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />

    {{-- CSS local --}}
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/public.css') }}" />

    @yield('head')
</head>
<body>
    {{-- Họa tiết trang trí (index có) --}}
    <div class="decoration-top-left" aria-hidden="true"></div>
    <div class="decoration-top-right" aria-hidden="true"></div>
    <div class="decoration-bottom-left" aria-hidden="true"></div>
    <div class="decoration-bottom-right" aria-hidden="true"></div>
    {{-- :contentReference[oaicite:2]{index=2} --}}

    {{-- HEADER: copy header trong index.html qua đây --}}
    <header role="banner">
        {{-- Bạn copy nguyên khối header từ index.html (nav-menu, dropdown user…) --}}
        {{-- Link html đổi sang route laravel (bên dưới tui đưa mẫu) --}}
        {{-- :contentReference[oaicite:3]{index=3} :contentReference[oaicite:4]{index=4} --}}
        @include('layouts.app')
    </header>

    <main>
        {{-- flash messages --}}
        @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert-error">{{ session('error') }}</div> @endif

        @yield('content')
    </main>

    {{-- FOOTER: copy footer trong index.html qua --}}
    

    {{-- JS --}}
    <script src="{{ asset('assets/js/script.js') }}" defer></script>
    <script src="{{ asset('assets/js/public.js') }}" defer></script>
    <script src="{{ asset('assets/js/cart.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
