@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
@php
    use Illuminate\Support\Str;
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
            <div class="mypage__profile">
                <h2 class="mypage__username">{{ $user->name }}</h2>

                @if(!is_null($averageScore))
                    <div class="mypage__rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $averageScore ? 'is-active' : '' }}">★</span>
                        @endfor
                    </div>
                @endif
            </div>

            <a href="{{ route('mypage.edit') }}" class="btn-edit">プロフィールを編集</a>
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

        <a href="{{ url('/mypage?page=trade') }}"
           class="tab {{ $page === 'trade' ? 'is-active' : '' }}">
           取引中の商品
           @if(isset($tradeItems) && $tradeItems->count())
               <span class="tab-count">{{ $tradeItems->count() }}</span>
           @endif
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

    {{-- =====================
         取引中の商品一覧
    ===================== --}}
@if ($page === 'trade')
    <div class="mypage-items-grid">
        @forelse ($tradeItems as $trade)
            <a href="{{ route('trades.show', $trade->id) }}" class="mypage-item-card">
                <div class="mypage-item-thumb mypage-item-thumb--trade">
                    @if ($trade->unread_messages_count > 0)
                        <span class="message-badge">{{ $trade->unread_messages_count }}</span>
                    @endif

                    <img src="{{ Str::startsWith($trade->item->image, 'http')
                        ? $trade->item->image
                        : asset('storage/' . $trade->item->image) }}"
                        alt="{{ $trade->item->name }}">
                </div>

                <p class="item-card__name">{{ $trade->item->name }}</p>

                <p class="item-card__meta">
                    @if ($trade->seller_id === $user->id)
                        購入者: {{ $trade->buyer->name ?? '---' }}
                    @else
                        出品者: {{ $trade->seller->name ?? '---' }}
                    @endif
                </p>
            </a>
        @empty
            <p>取引中の商品はありません。</p>
        @endforelse
    </div>
@endif
</div>
@endsection
