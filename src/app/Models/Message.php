<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'trade_id',
        'user_id',
        'message',
        'image',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
