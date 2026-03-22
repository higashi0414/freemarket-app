<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>取引チャット</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="trade-layout-header">
        <div class="trade-layout-header__inner">
            <a href="{{ url('/') }}" class="trade-layout-header__logo">
                <img src="{{ asset('images/coachtech-logo.svg') }}" alt="COACHTECH">
            </a>
        </div>
    </header>

    <main class="trade-layout-main">
        @yield('content')
    </main>
</body>

</html>