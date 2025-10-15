@extends('layouts.guest')

@section('title', 'ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
 <h1 class="page-title">ログイン</h1>

 <form method="POST" action="{{ route('login') }}" class="form" novalidate>
    @csrf
    <div class="form__group">
        <label for="email" class="form__label">メールアドレス</label>
        <input type="text" id="email" name="email" class="form__input" value="{{ old('email') }}">
        @error('email')
           <div class="form__error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form__group">
        <label for="password" class="form__label">パスワード</label>
        <input type="password" id="password" name="password" class="form__input">
        @error('password')
           <div class="form__error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form__actions">
        <button type="submit" class="btn btn--primary form__submit">ログインする</button>
    </div>
 </form>

  <div class="form__note">
   <a href="{{ route('register') }}">会員登録はこちら</a>
 </div>

@endsection


