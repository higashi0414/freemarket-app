@extends('layouts.app')

@section('title', $item->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
{{-- Font Awesome（コメントアイコン用） --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__thumb">

        @php
            $imagePath = Str::startsWith($item->image, 'http')
            ? $item->image
            : asset('storage/'. $item->image);
        @endphp
        <img src="{{ $imagePath }}" alt="{{ $item->name }}">

    </div>

    <div>
        <h1 class="item-detail__title">{{ $item->name }}</h1>

        @if($item->brand)
            <div class="item-detail__brand">{{ $item->brand }}</div>
        @endif

        <div class="item-detail__price">
            ¥{{ number_format($item->price) }} <span class="item-detail__tax">(税込)</span>
        </div>

        {{-- ★ 星マーク＋吹き出しをここに配置 --}}
        <div class="item-detail__icons">
            @auth
                @if(auth()->user()->likes->contains($item->id))
                    {{-- いいね済み：赤い星 --}}
                    <form action="{{ route('like.destroy', $item->id) }}" method="POST" class="like-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="like-btn">
                            <span class="star active">★</span>
                        </button>
                        {{-- ここにいいね数を移動（星の下に配置される） --}}
                        <span class="like-count">{{ $item->likes->count() }}</span>
                    </form>
                @else
                    {{-- 未いいね：白い星 --}}
                    <form action="{{ route('like.store', $item->id) }}" method="POST" class="like-form">
                        @csrf
                        <button type="submit" class="like-btn">
                            <span class="star">☆</span>
                        </button>
                        {{-- ここにいいね数を移動（星の下に配置される） --}}
                        <span class="like-count">{{ $item->likes->count() }}</span>
                    </form>
                @endif
            @else
                {{-- 未ログイン時 --}}
                <div class="like-form">
                    <p class="like-btn__guest">☆</p>
                    {{-- 未ログインでもカウントは表示 --}}
                    <span class="like-count">{{ $item->likes->count() }}</span>
                </div>
            @endauth

            {{-- 吹き出しアイコン（コメント数） --}}
            <div class="comment-icon">
                <i class="fa-regular fa-comment"></i>
                <span>{{ $item->comments->count() }}</span>
            </div>
        </div>
        {{-- ★ここまで --}}

        <a href="{{ route('purchase.show', ['item'=> $item->id]) }}" class="item-detail__buy">購入手続きへ</a>

        <div class="item-detail__section item-detail__section--description">
            <h3>商品説明</h3>
            <div class="item-detail__description">
                {!! nl2br(e($item->description)) !!}
            </div>
        </div>

        <div class="item-detail__section item-detail__section--info">
            <h3>商品の情報</h3>

            <div class="item-detail__info-row">
                <span class="item-detail__label">カテゴリー</span>
                <div class="item-detail__badges">
                    @foreach($item->categories as $category)
                        <span class="badge">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="item-detail__info-row">
                <span class="item-detail__label">商品の状態</span>
                <span class="item-detail__text">{{ $item->condition }}</span>
            </div>
        </div>

        <div class="item-detail__section item-detail__section-comments">
            <h3>コメント ({{ $item->comments->count() }})</h3>

            @foreach($item->comments as $comment)
            <div class="comment">
                <div class="comment__avatar"></div>
                <div class="comment__content">
                    <div class="comment__author">{{ $comment->user->name }}</div>
                    <div class="comment__box">{{ $comment->body }}</div>
                </div>
            </div>
            @endforeach

            @auth 
            <form class="comment-form" method="POST" action="{{ route('comments.store', $item->id) }}">
                @csrf
                <h4 class="comment-form__title">商品へのコメント</h4>
                <textarea name="body" class="comment-form__textarea" placeholder="コメントを入力してください"></textarea>

                <button type="submit" class="comment-form__submit">コメントを送信する</button>
            </form>
            @else
            <p class="comment-login-msg">※コメントするにはログインが必要です。</p>
            @endauth
        </div>
    </div>
</div>
@endsection

