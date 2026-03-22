<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\Trade;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request, Trade $trade)
    {
        $user = Auth::user();

        if ($user->id !== $trade->seller_id && $user->id !== $trade->buyer_id) {
            abort(403);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        Message::create([
            'trade_id' => $trade->id,
            'user_id' => $user->id,
            'message' => $request->input('message'),
            'image' => $imagePath,
            'read_at' => null,
        ]);

        $trade->touch();

        return redirect()->route('trades.show', $trade->id);
    }

    

        public function update(StoreMessageRequest $request, Message $message)
    {
        $user = Auth::user();

        if ($message->user_id !== $user->id) {
            abort(403);
        }

        $imagePath = $message->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        $message->update([
            'message' => $request->input('message'),
            'image' => $imagePath,
        ]);

        return redirect()->route('trades.show', $message->trade_id);
    }

    public function destroy(Message $message)
    {
        $user = Auth::user();

        if ($message->user_id !== $user->id) {
            abort(403);
        }

        $tradeId = $message->trade_id;

        $message->delete();

        return redirect()->route('trades.show', $tradeId);
    }
}
