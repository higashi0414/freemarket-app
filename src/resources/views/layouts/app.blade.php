<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'COACHTECH Market')</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>
<body>

  <header class="site-header">
    <div class="site-header__inner">
      <div class="site-header__logo">
        <img src="{{ asset('images/coachtech-logo.svg') }}" alt="COACHTECH" height="30">
      </div>

      <form class="site-header__search" action="{{ route('items.index') }}" method="GET">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">

        {{-- 現在のタブ状態を保持 --}}
        <input type="hidden" name="tab" value="{{ request('tab', 'recommend') }}">
      </form>

      <nav class="site-header__nav">
        @if(Auth::check())
        <form method="POST" action="{{ route('logout') }}" class="site-header__logout">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
        <a href="{{ route('mypage') }}">マイページ</a>
        <a href="{{ route('items.create') }}" class="header__sell">出品</a>
        @else
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('mypage') }}">マイページ</a>
        <a href="{{ route('items.create') }}" class="header__sell">出品</a>
        @endif

      </nav>
    </div>
  </header>

  <main class="container">
    @yield('content')
  </main>
</body>
</html>
