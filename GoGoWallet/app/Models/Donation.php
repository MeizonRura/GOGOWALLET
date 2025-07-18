<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rekening_tujuan', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
