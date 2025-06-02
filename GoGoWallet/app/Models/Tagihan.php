<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = ['nama_pelanggan', 'deskripsi', 'jumlah', 'status_dibayar'];
}
