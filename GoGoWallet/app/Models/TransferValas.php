<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferValas extends Model
{
    protected $table = 'transfer_valas';

    protected $fillable = [
        'user_id',
        'account_number',
        'recipient_name',
        'recipient_bank',
        'currency',
        'amount',
        'exchange_rate',
        'total_in_local',
        'transfer_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
