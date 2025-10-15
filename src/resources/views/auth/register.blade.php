@extends('layouts.guest')

@section('title', '会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
 <h1 class="page-title">会員登録</h1>


 <form method="POST" action="{{ route('register') }}" class="form" novalidate>
  @csrf

  <div class="form__group">
    <label for="name" class="form__label">ユーザー名</label>
    <input type="text" id="name" name="name"
           class="form__input"
           value="{{ old('name') }}"
           autocomplete="name" autofocus>
    @error('name')
       <div class="form__error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form__group">
    <label for="email" class="form__label">メールアドレス</label>
    <input type="email" id="email" name="email"
           class="form__input"
           value="{{ old('email') }}"
           autocomplete="email">
    @error('email')
        <div class="form__error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form__group">
    <label for="password" class="form__label">パスワード</label>
    <input type="password" id="password" name="password"
           class="form__input"
           autocomplete="new-password">
    @error('password')
        <div class="form__error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form__group">
    <label for="password_confirmation" class="form__label">確認用パスワード</label>
    <input type="password" id="password_confirmation" name="password_confirmation" 
           class="form__input"
           autocomplete="new-password">
    @error('password_confirmation')
        <div class="form__error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form__actions">
    <button type="submit" class="btn btn--primary form__submit">登録する</button>
  </div>
 </form>

 <div class="form__note">
   <a href="{{ route('login') }}">ログインはこちら</a>
 </div>
@endsection