<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class LikeController extends Controller
{

    public function store(Item $item)
    {
        $user = auth()->user();

        if (!$user->likes()->where('item_id', $item->id)->exists()) {
            $user->likes()->attach($item->id);
        }

        return back();
    }

    public function destroy(Item $item)
    {
        $user = auth()->user();

        if ($user->likes()->where('item_id', $item->id)->exists()) {
            $user->likes()->detach($item->id);
        }

        return back();
    }
}
