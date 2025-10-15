<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    /**
     * 商品一覧（おすすめ / マイリストタブ + 検索対応）
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        // おすすめタブ → 全商品（※自分が出品した商品は除外する）
        if ($tab === 'recommend') {
            $items = Item::query()
                ->when($user, function ($query) use ($user) {
                    // ログイン中のユーザーが出品した商品を除外
                    $query->where('user_id', '!=', $user->id);
                })
                ->when($keyword, function ($query, $keyword) {
                    // 検索ワードで部分一致検索
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->get();
        }

        // マイリストタブ → 自分が「いいね」した商品だけ
        elseif ($tab === 'mylist' && $user) {
            $items = $user->likes()
                ->when($keyword, function ($query, $keyword) {
                    // マイリスト内でも部分一致検索可能に
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->get();
        }

        // 未ログインで「マイリスト」にアクセスした場合 → 空配列
        else {
            $items = collect();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    /**
     * 商品詳細
     */
    public function show($id)
    {
        $item = Item::with(['categories', 'user', 'comments.user'])->findOrFail($id);
        return view('items.show', compact('item'));
    }

    /**
     * 商品出品ページ
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('items.create', compact('categories'));
    }
    public function store(Request $request)
    {

        // 入力内容のバリデーション（確認）
        $request->validate([
            'name' => 'required|string|max:255', // 商品名（必須）
            'brand' => 'nullable|string|max:255', // ブランド名（空でもOK）
            'description' => 'required|string', // 商品説明（必須）
            'price' => 'required|integer|min:0', // 価格（0円以上の整数）
            'condition' => 'required|string', // 商品状態（必須）
            'categories' => 'required|array', // カテゴリ（必須）
            'image' => 'required|image|max:2048', // 画像（必須・2MBまで）
        ]);

        $path = $request->file('image')->store('items', 'public');

        $item = new \App\Models\Item();
        $item->fill([
        'name' => $request->name,
        'brand' => $request->brand,
        'description' => $request->description,
        'price' => $request->price,
        'condition' => $request->condition,
        'image' => $path,
        'user_id' => Auth::id(),
    ]);

        // 保存
        $item->save();

        $item->categories()->attach($request->categories);

        // 出品完了後、トップページ（商品一覧）へリダイレクト
        return redirect()->route('mypage.index')->with('success', '商品を出品しました！');
    }

    /**
     * 商品購入ページ
     */
    public function purchase()
    {
        return view('items.purchase');
    }

 /**
     * 商品購入処理（購入ボタン押下時）
     */
    public function purchaseStore($id)
    {
        $item = Item::findOrFail($id);

        if ($item->is_sold || Purchase::where('item_id', $item->id)->exists()) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに購入されています。');
        }

        // DBトランザクションで安全に処理
        DB::transaction(function () use ($item) {
            // 購入履歴登録
            Purchase::create([
                'user_id'  => Auth::id(),
                'item_id'  => $item->id,
                'zipcode'  => Auth::user()->zipcode,
                'address'  => Auth::user()->address,
                'building' => Auth::user()->building,
            ]);

            // 商品を「売り切れ」に変更
            $item->is_sold = true;
            $item->save();
        });

        // 一覧画面へリダイレクト
        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }
}



