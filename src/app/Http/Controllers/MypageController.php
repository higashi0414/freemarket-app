<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Trade;
use App\Models\Rating;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $sellItems = collect();
        $buyItems = collect();
        $tradeItems = collect();

        $rawAverageScore = Rating::where('to_user_id', $user->id)->avg('score');
        $averageScore = is_null($rawAverageScore) ? null : round($rawAverageScore);

        if ($page === 'buy') {
            $buyItems = Purchase::where('user_id', $user->id)
                ->with('item')
                ->get()
                ->pluck('item');
        } elseif ($page === 'trade') {
            $tradeItems = Trade::with(['item', 'seller', 'buyer'])
                ->where(function ($query) use ($user) {
                    $query->where('seller_id', $user->id)
                          ->orWhere('buyer_id', $user->id);
                })
                ->withCount(['messages as unread_messages_count' => function ($query) use ($user) {
                    $query->where('user_id', '!=', $user->id)
                          ->whereNull('read_at');
                }])
                ->orderByDesc('updated_at')
                ->get();
        } else {
            $sellItems = $user->items()->get();
        }

        return view('mypage', compact(
            'user',
            'sellItems',
            'buyItems',
            'tradeItems',
            'page',
            'averageScore'
        ));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('mypage_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->input('name');
        $user->zipcode = $request->input('zipcode');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        $user->save();

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました！');
    }
}
