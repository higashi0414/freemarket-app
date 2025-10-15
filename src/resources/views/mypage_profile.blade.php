@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}">
@endsection

@section('content')
<div class="mypage-profile">
    <h1 class="mypage__title">プロフィール設定</h1>

    <form class="mypage-profile__form" method="POST" action="{{ route('mypage.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mypage-profile__avatar">
            {{-- プロフィール画像 (あれば表示、なければ仮画像) --}}
            <img id="avatar-preview"
                 src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/100x100.png?text=Avatar' }}"
                 alt="プロフィール画像" class="mypage-profile__avatar-img">


            <label for="avatar" class="btn btn--outline">画像を選択する</label>
            <input type="file" name="avatar" id="avatar" accept="image/*"style="display: none;">
        </div>


        <div class="form__group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name',$user->name) }}">
        </div>

        <div class="form__group">
            <label for="zipcode">郵便番号</label>
            <input type="text" id="zipcode" name="zipcode" value="{{ old('zipcode',$user->zipcode) }}">
        </div>

        <div class="form__group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="form__group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button type="submit" class="btn btn--primary">更新する</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const preview = document.getElementById('avatar-preview');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // 選んだ画像をプレビュー表示
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
