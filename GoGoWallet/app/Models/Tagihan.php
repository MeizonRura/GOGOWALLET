<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_rekening',
        'nominal_tagihan',
        'deskripsi',
        'status_dibayar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
