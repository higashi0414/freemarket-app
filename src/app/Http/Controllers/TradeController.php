<?php

namespace App\Http\Controllers;

use App\Mail\TradeCompletedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Trade;
use App\Models\Rating;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function show(Trade $trade)
    {
        $user = Auth::user();

        if ($trade->seller_id !== $user->id && $trade->buyer_id !== $user->id) {
            abort(403);
        }

        Message::where('trade_id', $trade->id)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
        ]);



        $trade->load([
            'item',
            'seller',
            'buyer',
            'messages' => function ($query) {
                $query->with('user')->oldest();
            },
        ]);

        $partner = $trade->seller_id === $user->id
            ? $trade->buyer
            : $trade->seller;

        $otherTrades = Trade::with('item')
            ->where(function ($query) use ($user) {
                $query->where('seller_id', $user->id)
                      ->orWhere('buyer_id', $user->id);
            })
            ->where('id', '!=', $trade->id)
            ->latest()
            ->get();

        $isSeller = $trade->seller_id === $user->id;
        $isBuyer = $trade->buyer_id === $user->id;

        $buyerRated = Rating::where('trade_id', $trade->id)
            ->where('from_user_id', $trade->buyer_id)
            ->exists();

        $sellerRated = Rating::where('trade_id', $trade->id)
            ->where('from_user_id', $trade->seller_id)
            ->exists();

        return view('trades.show', compact(
            'trade',
            'user',
            'partner',
            'otherTrades',
            'isSeller',
            'isBuyer',
            'buyerRated',
            'sellerRated'
        ));
    }

    public function complete(Trade $trade)
    {
        $user = Auth::user();

        if ($trade->buyer_id !== $user->id) {
            abort(403);
        }

        if ($trade->buyer_completed) {
            return back();
        }

        $trade->update([
            'buyer_completed' => true,
        ]);

        return redirect()
            ->route('trades.show', $trade->id)
            ->with('show_buyer_rating_modal', true);
    }

    public function storeRating(Request $request, Trade $trade)
    {
        $user = Auth::user();

        if ($trade->buyer_id !== $user->id && $trade->seller_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $alreadyRated = Rating::where('trade_id', $trade->id)
            ->where('from_user_id', $user->id)
            ->exists();

        if ($alreadyRated) {
            return redirect()->route('items.index');
        }

        $sendMailToSeller = false;

        if ($user->id === $trade->buyer_id) {
            $toUserId = $trade->seller_id;
            $sendMailToSeller = true;
        } else {
            if (!$trade->buyer_completed) {
                abort(403);
            }

            $toUserId = $trade->buyer_id;
            $trade->seller_completed = true;
        }

        Rating::create([
            'trade_id' => $trade->id,
            'from_user_id' => $user->id,
            'to_user_id' => $toUserId,
            'score' => $request->score,
        ]);

        if ($trade->buyer_completed && $trade->seller_completed) {
            $trade->status = 'completed';
        }

        $trade->save();

        if ($sendMailToSeller) {
            $trade->load(['seller', 'buyer', 'item']);
            Mail::to($trade->seller->email)->send(new TradeCompletedMail($trade));
    }

        return redirect()->route('items.index');
    }
}