@extends('layouts.app')

@section('title', '住所の変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_address.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
  <h1 class="address-edit-title">住所の変更</h1>

  <form method="POST" action="{{ route('purchase.address.update', ['item' => $item->id]) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="zipcode">郵便番号</label>
      <input type="text" id="zipcode" name="zipcode" value="{{ old('zipcode', $purchase->zipcode ?? $user->zipcode) }}">
    </div>

    <div class="form-group">
      <label for="address">住所</label>
      <input type="text" id="address" name="address" value="{{ old('address', $purchase->address ?? $user->address) }}">
    </div>

    <div class="form-group">
      <label for="building">建物名</label>
      <input type="text" id="building" name="building" value="{{ old('building', $purchase->building ?? $user->building) }}">
    </div>

    <button type="submit" class="btn btn--primary">更新する</button>
  </form>
</div>
@endsection
