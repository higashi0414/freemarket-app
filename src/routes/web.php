<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {

//商品出品
Route::get('/items/create' , [ItemsController::class, 'create'])->name('items.create');
Route::post('/items', [ItemsController::class, 'store'])->name('items.store');

//商品購入
Route::get('/items/purchase', [ItemsController::class, 'purchase'])->name('items.purchase');
//マイページ
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
//プロフィール編集
Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.edit');
Route::put('/mypage/profile', [MypageController::class, 'update'])->name('mypage.update');



});


//商品一覧トップ画面
Route::get('/', [ItemsController::class, 'index'])->name('items.index');

//商品詳細
Route::get('/items/{id}', [ItemsController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {
    Route::post('/items/{item}/like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/items/{item}/like', [LikeController::class, 'destroy'])->name('like.destroy');
    Route::post('/items/{item}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])
        ->name('purchase.address');

    Route::put('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
        ->name('purchase.address.update');

    Route::post('/purchase/{item}', [App\Http\Controllers\ItemsController::class, 'purchaseStore'])
    ->name('purchase.store');
});


