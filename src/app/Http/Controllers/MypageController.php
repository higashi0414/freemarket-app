<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class MypageController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        if ($page === 'buy'){
            $buyItems = Purchase::where('user_id', $user->id)
                ->with('item')
                ->get()
                ->pluck('item');

            $sellItems = collect();
        } else {
            $sellItems = $user->items()->get();
            $buyItems = collect();
        }
        return view('mypage', compact('user', 'sellItems', 'buyItems', 'page'));
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

        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました！');
    }
}
