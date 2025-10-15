<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH Market')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="site-header site-header--guest">
        <div class="site-header__inner">
            <div class="site-header__logo">
                <img src="{{ asset('images/coachtech-logo.svg') }}" alt="COACHTECH" height="30">
            </div>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>