<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'date_of_birth',
        'profile_photo',
        'account_number',
        'balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->account_number = self::generateUniqueAccountNumber();
        });
    }

    protected static function generateUniqueAccountNumber()
    {
        do {
            $number = mt_rand(1000000000000000, 9999999999999999);
        } while (self::where('account_number', $number)->exists());

        return $number;
    }

    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_id');
    }
}