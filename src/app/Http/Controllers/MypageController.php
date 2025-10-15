<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class MypageController extends Controller
{
    /**
     * マイページ表示
     */
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

    /**
     * プロフィール編集画面表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('mypage_profile', compact('user'));
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション（画像も含む）
        $request->validate([
            'name' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048', // 画像ファイルを許可
        ]);

        // 画像アップロード処理
        if ($request->hasFile('avatar')) {
            // storage/app/public/avatars に保存される
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path; // ← DBに保存される文字列は「avatars/ファイル名.png」
        }

        // 他の情報も更新
        $user->name = $request->input('name');
        $user->zipcode = $request->input('zipcode');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        // データベースに保存
        $user->save();

        // 更新後はマイページに戻る
        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました！');
    }
}
