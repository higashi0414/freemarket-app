@extends('layouts.app')

@section('title', '商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
  <div class="purchase-wrapper">


    <div class="purchase-left">
       <div class="purchase-item">
         <div class="purchase-item__thumb">
           <img src="{{ $item->image }}" alt="{{ $item->name }}">
         </div>
         <div class="purchase-item__info">
         <h2 class="purchase-item__name">{{ $item->name }}</h2>
         <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
        </div>
       </div>
       <hr class="sep">

    <div class="purchase-method">
      <h3 class="section-title">支払い方法</h3>

      <select id="payment" name="payment" class="form-input">
          <option value="">選択してください</option>
          <option value="card">カード支払い</option>
          <option value="convenience">コンビニ払い</option>
        </select>
      </div>
      <hr class="sep">

      <div class="purchase-address">
        <h3 class="section-title">配送先</h3>

        @php
          $purchaseAddress = $purchase?->address ?? $user->address;
          $purchaseZip = $purchase?->zipcode ?? $user->zipcode;
          $purchaseBuilding = $purchase?->building ?? $user->building;
        @endphp

        @if($purchaseAddress)
        <p>〒 {{ $purchaseZip }}</p>
        <p>{{ $purchaseAddress }} {{ $purchaseBuilding }}</p>
        @else
         <p>住所が登録されていません。</p>
        <a href="{{ route('mypage.edit') }}" class="address-edit">プロフィールで登録する</a>
        @endif

        <a href="{{ route('purchase.address', ['item' => $item->id]) }}" class="address-edit">変更する</a>
      </div>
      <hr class="sep">
    </div>

    <div class="purchase-right">
        <div class="summary-box">
            <p class="summary-row">
                <span>商品代金</span>
                <span>¥{{ number_format($item->price) }}</span>
            </p>
            <p class="summary-row">
                <span>支払い方法</span>
                <span id="summary-payment">選択されていません</span>
            </p>
        </div>
        <div class="form-actions">

          @if ($item->is_sold)
              <button type="button" class="btn btn--disabled" disabled>販売済み</button>
          @else
          <form method="POST" action="{{ route('purchase.store', ['item' => $item->id]) }}">
            @csrf
            <button type="submit" class="btn btn--primary">購入する</button>
          </form>
          @endif
        </div>
    </div>

  </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
  const select = document.getElementById('payment');
  const summary = document.getElementById('summary-payment');

  if (select && summary) {
    select.addEventListener('change', function() {
      const selectedText = this.options[this.selectedIndex].text;
      summary.textContent = selectedText;
    });
  }
});
</script>

