<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'item_id',
        'seller_id',
        'buyer_id',
        'status',
        'buyer_completed',
        'seller_completed',

    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }


}
