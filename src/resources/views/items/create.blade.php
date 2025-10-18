@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection


@section('content')
<div class="create-wrapper">
    <h1 class="create-title">商品の出品</h1>

    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="create-form" novalidate>
        @csrf

        <div class="form-group">
            <label for="image" class="form-label">商品画像</label>

            <div class="image-preview" id="preview"></div>

            <div class="image-upload">
                <label for="image" class="image-upload__label">画像を選択する</label>
                <input type="file" id="image" name="image" class="image-upload__input" required>
            </div>
        </div>

        <h2 class="section-title">商品の詳細</h2>
        <hr class="sep">

        <div class="form-group">
            <span class="form-label">カテゴリー</span>
            <div class="category-options">
                @foreach($categories as $category)
                <label class="category-option">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                    {{ $category->name }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="condition" class="form-label">商品の状態</label>
            <select id="condition" name="condition" class="form-input">
                <option value="">選択してください</option>
                <option value="new">新品</option>
                <option value="used_good">中古（良好）</option>
                <option value="used-bad">中古（傷あり）</option>
            </select>
        </div>

        <h2 class="section-title">商品名と説明</h2>
        <hr class="sep">

        <div class="form-group">
            <label for="name" class="form-label">商品名</label>
            <input type="text" id="name" name="name" class="form-input">
        </div>

        <div class="form-group">
            <label for="brand" class="form-label">ブランド名</label>
            <input type="text" id="brand" name="brand" class="form-input">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">商品の説明</label>
            <textarea id="description" name="description" class="form-input" rows="5" ></textarea>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">販売価格</label>
            <input type="number" id="price" name="price" class="form-input" placeholder="￥" required>
           </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary">出品する</button>
        </div>
    </form>
</div>

<script>
document.getElementById('image').addEventListener('change', function (event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.borderRadius = '8px';
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection