<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferValas extends Model
{
    protected $table = 'transfer_valas';

    protected $fillable = [
        'user_id',
        'account_number',
        'recipient_bank',
        'currency',
        'amount_idr',
        'exchange_rate',
        'amount_valas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
