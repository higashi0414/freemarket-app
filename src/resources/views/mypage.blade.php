@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="mypage">
    {{-- =====================
         ヘッダー部分（プロフィール情報）
    ===================== --}}
    <div class="mypage__header">
        <div class="mypage__avatar">
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}"
                     alt="プロフィール画像"
                     class="mypage__avatar-img">
            @else
                <img src="https://via.placeholder.com/100x100.png?text=Avatar"
                     alt="プロフィール画像"
                     class="mypage__avatar-img">
            @endif
        </div>

        <div class="mypage__info">
            <h2 class="mypage__username">{{ $user->name }}</h2>
            <a href="{{ route('mypage.edit') }}" class="btn-edit">プロフィールの編集</a>
        </div>
    </div>

    {{-- =====================
         タブ切り替え
    ===================== --}}
    <div class="mypage__tabs">
        <a href="{{ url('/mypage?page=sell') }}"
           class="tab {{ $page === 'sell' ? 'is-active' : '' }}">
           出品した商品
        </a>

        <a href="{{ url('/mypage?page=buy') }}"
           class="tab {{ $page === 'buy' ? 'is-active' : '' }}">
           購入した商品
        </a>
    </div>

    {{-- =====================
         出品した商品一覧
    ===================== --}}
    @if ($page === 'sell')
        <div class="mypage-items-grid">
            @forelse ($sellItems as $item)
                <a href="{{ route('items.show', $item->id) }}" class="mypage-item-card">
                    <div class="mypage-item-thumb">
                        <img src="{{ Str::startsWith($item->image, 'http')
                            ? $item->image
                            : asset('storage/' . $item->image) }}"
                            alt="{{ $item->name }}">
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            @empty
                <p>出品した商品はありません。</p>
            @endforelse
        </div>
    @endif

    {{-- =====================
         購入した商品一覧
    ===================== --}}
    @if ($page === 'buy')
        <div class="mypage-items-grid">
            @forelse ($buyItems as $item)
                <a href="{{ route('items.show', $item->id) }}" class="mypage-item-card">
                    <div class="mypage-item-thumb">
                        <img src="{{ Str::startsWith($item->image, 'http')
                            ? $item->image
                            : asset('storage/' . $item->image) }}"
                            alt="{{ $item->name }}">
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            @empty
                <p>購入した商品はありません。</p>
            @endforelse
        </div>
    @endif
</div>
@endsection
