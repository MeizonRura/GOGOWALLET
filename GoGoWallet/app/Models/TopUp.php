<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $table = 'topups';

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'payment_method'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}