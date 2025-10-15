<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class LikeController extends Controller
{
    /**
     * いいね登録
     */
    public function store(Item $item)
    {
        $user = auth()->user();

        // すでに「いいね」しているか確認
        if (!$user->likes()->where('item_id', $item->id)->exists()) {
            $user->likes()->attach($item->id);
        }

        return back(); // 元のページ（商品詳細など）に戻る
    }

    /**
     * いいね解除
     */
    public function destroy(Item $item)
    {
        $user = auth()->user();

        // 「いいね」済みなら削除
        if ($user->likes()->where('item_id', $item->id)->exists()) {
            $user->likes()->detach($item->id);
        }

        return back();
    }
}
