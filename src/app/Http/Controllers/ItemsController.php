<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        if ($tab === 'recommend') {
            $items = Item::query()
                ->when($user, function ($query) use ($user) {
                    $query->where('user_id', '!=', $user->id);
                })
                ->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->get();
        }

        elseif ($tab === 'mylist' && $user) {
            $items = $user->likes()
                ->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->get();
        }

        else {
            $items = collect();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function show($id)
    {
        $item = Item::with(['categories', 'user', 'comments.user'])->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('items.create', compact('categories'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'condition' => 'required|string',
            'categories' => 'required|array',
            'image' => 'required|image|max:2048',
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


        $item->save();

        $item->categories()->attach($request->categories);

        return redirect()->route('mypage.index')->with('success', '商品を出品しました！');
    }

    public function purchase()
    {
        return view('items.purchase');
    }


    public function purchaseStore($id)
    {
        $item = Item::findOrFail($id);

        if ($item->is_sold || Purchase::where('item_id', $item->id)->exists()) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに購入されています。');
        }


        DB::transaction(function () use ($item) {

            Purchase::create([
                'user_id'  => Auth::id(),
                'item_id'  => $item->id,
                'zipcode'  => Auth::user()->zipcode,
                'address'  => Auth::user()->address,
                'building' => Auth::user()->building,
            ]);

            $item->is_sold = true;
            $item->save();
        });

        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }
}



