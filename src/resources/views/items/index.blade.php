@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
@php
  $activeTab = $tab ?? 'recommend';
@endphp

{{-- =====================
    タブ（おすすめ／マイリスト）
===================== --}}
<div class="tabs" role="tablist" aria-label="商品タブ">

  {{-- おすすめタブ --}}
  <a href="{{ route('items.index', [
          'tab' => 'recommend',
          'keyword' => request('keyword') // 検索状態を保持
      ]) }}"
      class="tabs__item {{ $activeTab === 'recommend' ? 'is-active' : '' }}"
      role="tab"
      aria-selected="{{ $activeTab === 'recommend' ? 'true' : 'false' }}">
      おすすめ
  </a>

  {{-- マイリストタブ --}}
  @auth
      <a href="{{ route('items.index', [
              'tab' => 'mylist',
              'keyword' => request('keyword')
          ]) }}"
          class="tabs__item {{ $activeTab === 'mylist' ? 'is-active' : '' }}"
          role="tab"
          aria-selected="{{ $activeTab === 'mylist' ? 'true' : 'false' }}">
          マイリスト
      </a>
  @else
      <span class="tabs__item tabs__item--disabled">マイリスト</span>
  @endauth
</div>

{{-- =====================
    商品一覧
===================== --}}
<div class="items-grid mt-24">
    @forelse ($items as $it)
        <a href="{{ route('items.show', $it->id) }}" class="item-card">
            <div class="item-card__thumb">

                @php
                    $imagePath = Str::startsWith($it->image, 'http')
                        ? $it->image
                        : asset('storage/' . $it->image);
                @endphp
                <img src="{{ $imagePath }}" alt="{{ $it->name }}">

                @if($it->is_sold)
                    <span class="item-card__sold">SOLD</span>
                @endif
            </div>

          <div class="item-card__info">
            <p class="item-card__name">{{ $it->name }}</p>
            <p class="item-card__price">￥{{ number_format($it->price) }}</p>
          </div>
        </a>
    @empty
        <p class="no-items">商品が見つかりません。</p>
    @endforelse
</div>
@endsection

