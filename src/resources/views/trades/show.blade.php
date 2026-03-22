@extends('layouts.trade')

@section('css')
<link rel="stylesheet" href="{{ asset('css/trades/show.css') }}">
@endsection

@section('content')
<div class="trade">
    <aside class="trade-sidebar">
        <h2 class="trade-sidebar__title">その他の取引</h2>

        @forelse ($otherTrades as $otherTrade)
            <a href="{{ route('trades.show', $otherTrade->id) }}" class="trade-sidebar__item">
                {{ $otherTrade->item->name }}
            </a>
        @empty
            <p class="trade-sidebar__empty">他の取引はありません</p>
        @endforelse
    </aside>

    <main class="trade-main">
        <div class="trade-header">
            <div class="trade-header__user">
                <div class="trade-header__avatar"></div>
                <h1>「{{ $partner->name }}」さんとの取引画面</h1>
            </div>

            @if ($isBuyer && !$trade->buyer_completed)
                <form action="{{ route('trades.complete', $trade->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="trade-header__complete">
                        取引を完了する
                    </button>
                </form>
            @endif
        </div>

        @php
            use Illuminate\Support\Str;
        @endphp

        <div class="trade-product">
            <div class="trade-product__image">
                @if ($trade->item->image)
                    @if (Str::startsWith($trade->item->image, 'http'))
                        <img src="{{ $trade->item->image }}" alt="{{ $trade->item->name }}">
                    @else
                        <img src="{{ asset('storage/' . $trade->item->image) }}" alt="{{ $trade->item->name }}">
                    @endif
                @endif
            </div>

            <div class="trade-product__info">
                <h2>{{ $trade->item->name }}</h2>
                <p>¥{{ number_format($trade->item->price) }}</p>
            </div>
        </div>

        <div class="trade-messages">
            @foreach ($trade->messages as $message)
                @if ($message->user_id === $user->id)
                    <div class="trade-message trade-message--self">
                        <div class="trade-message__meta">
                            <span>{{ $message->user->name }}</span>
                        </div>

                        <div class="trade-message__body">
                            <p>{{ $message->message }}</p>
                        </div>

                        @if ($message->image)
                            <div class="trade-message__image">
                                <img src="{{ asset('storage/' . $message->image) }}" alt="メッセージ画像">
                            </div>
                        @endif

                        <div class="trade-message__actions">
                            <a href="#"
                               onclick="document.getElementById('edit-{{ $message->id }}').style.display='block'; return false;">
                                編集
                            </a>

                            <form action="{{ route('messages.destroy', $message->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </div>

                        <form id="edit-{{ $message->id }}"
                              action="{{ route('messages.update', $message->id) }}"
                              method="POST"
                              style="display:none; margin-top: 8px;">
                            @csrf
                            @method('PUT')

                            <input type="text" name="message" value="{{ $message->message }}">
                            <button type="submit">更新</button>
                        </form>
                    </div>
                @else
                    <div class="trade-message trade-message--other">
                        <div class="trade-message__meta">
                            <span>{{ $message->user->name }}</span>
                        </div>

                        <div class="trade-message__body">
                            <p>{{ $message->message }}</p>
                        </div>

                        @if ($message->image)
                            <div class="trade-message__image">
                                <img src="{{ asset('storage/' . $message->image) }}" alt="メッセージ画像">
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        @if ($errors->any())
            <div class="trade-form__errors">
                @foreach ($errors->all() as $error)
                    <p class="trade-form__error">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('messages.store', $trade->id) }}" method="POST" class="trade-form" enctype="multipart/form-data">
            @csrf

            <input
                type="text"
                name="message"
                value="{{ old('message') }}"
                placeholder="取引メッセージを記入してください"
                class="trade-form__input"
            >

            <label for="image" class="trade-form__image">
                画像を追加
            </label>
            <input type="file" id="image" name="image" hidden>

            <button type="submit" class="trade-form__submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10l18-7-7 18-2-7-9-4z" />
                </svg>
            </button>
        </form>

        @if (
            (session('show_buyer_rating_modal') && $isBuyer && !$buyerRated) ||
            ($trade->buyer_completed && $isSeller && !$sellerRated)
        )
            <div class="trade-modal-overlay">
                <div class="trade-modal">
                    <form action="{{ route('trades.rating', $trade->id) }}" method="POST">
                        @csrf

                        <div class="trade-modal__header">
                            <h2>取引が完了しました。</h2>
                        </div>

                        <div class="trade-modal__body">
                            <p>今回の取引相手はどうでしたか？</p>

                            <div class="trade-rating">
                                <input type="radio" id="star5" name="score" value="5" {{ old('score') == 5 ? 'checked' : '' }}>
                                <label for="star5" class="trade-rating__label">★</label>

                                <input type="radio" id="star4" name="score" value="4" {{ old('score') == 4 ? 'checked' : '' }}>
                                <label for="star4" class="trade-rating__label">★</label>

                                <input type="radio" id="star3" name="score" value="3" {{ old('score') == 3 ? 'checked' : '' }}>
                                <label for="star3" class="trade-rating__label">★</label>

                                <input type="radio" id="star2" name="score" value="2" {{ old('score') == 2 ? 'checked' : '' }}>
                                <label for="star2" class="trade-rating__label">★</label>

                                <input type="radio" id="star1" name="score" value="1" {{ old('score') == 1 ? 'checked' : '' }}>
                                <label for="star1" class="trade-rating__label">★</label>
                            </div>

                            @error('score')
                                <p class="trade-rating__error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="trade-modal__footer">
                            <button type="submit" class="trade-modal__submit">送信する</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </main>
</div>
@endsection