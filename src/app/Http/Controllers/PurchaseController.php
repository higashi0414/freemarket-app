<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    public function show(Item $item)
    {
        $user = Auth::user();

        $purchase = Purchase::where('user_id', $user->id)
                            ->where('item_id', $item->id)
                            ->first();

        return view('purchase', compact('item', 'user', 'purchase'));
    }


    public function editAddress(Item $item)
    {
        $user = Auth::user();

        $purchase = Purchase::where('user_id', $user->id)
                            ->where('item_id', $item->id)
                            ->first();

        return view('purchase_address', compact('item', 'user', 'purchase'));
    }

    public function updateAddress(Request $request, Item $item)
    {
        $request->validate([
            'zipcode' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $purchase = Purchase::firstOrCreate([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $purchase->update([
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        // 購入画面にリダイレクト
        return redirect()->route('purchase.show', ['item' => $item->id])
                         ->with('success', '配送先住所を更新しました。');
    }
}
