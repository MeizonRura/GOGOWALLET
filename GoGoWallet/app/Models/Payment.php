<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'va_number',
        'amount',
        'status',
        'description'
    ];

    protected $connection = 'pembayaran';
    protected $table = 'pembayarans'; // sesuaikan dengan nama tabel
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}