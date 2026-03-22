<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\Trade;
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

        return redirect()->route('purchase.show', ['item' => $item->id])
                         ->with('success', '配送先住所を更新しました。');
    }

    public function store(Request $request, Item $item)
    {
        $user = Auth::user();
        $request->validate([
            'payment' => 'required|in:card,convenience',
            ], [
                'payment.required' => '支払い方法を選択してください。',
                'payment.in' => '正しい支払い方法を選択してください。',
            ]);
        $purchase = Purchase::firstOrCreate([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ], [
            'payment_method' => $request->payment,
            'zipcode' => $user->zipcode,
            'address' => $user->address,
            'building' => $user->building,
    ]);
    
            $purchase->update([
            'payment_method' => $request->payment,
            'zipcode' => $purchase->zipcode ?? $user->zipcode,
            'address' => $purchase->address ?? $user->address,
            'building' => $purchase->building ?? $user->building,
        ]);

        Trade::firstOrCreate(
            [
                'purchase_id' => $purchase->id,
            ],
            [
                'item_id' => $item->id,
                'seller_id' => $item->user_id,
                'buyer_id' => $user->id,
                'status' => 'trading',
            ]
        );


        $item->update(['is_sold' => true]);
        return redirect()
        ->route('mypage')
        ->with('success', '購入が完了しました！');
    }
}

