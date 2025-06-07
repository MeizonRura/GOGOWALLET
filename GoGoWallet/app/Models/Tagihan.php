<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = ['nama_rekening', 'nomor_rekening', 'nominal_tagihan', 'deskripsi', 'status_dibayar'];
}
