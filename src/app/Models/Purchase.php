<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method',
        'zipcode',
        'address',
        'building',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\Item::class);
    }

    public function trade()
    {
        return $this->hasOne(Trade::class);
    }
}
