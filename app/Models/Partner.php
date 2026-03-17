<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Partner extends Authenticatable
{
    use Notifiable;
    protected $table = 'partners';

    protected $guard = 'partner';

    protected $fillable = [
        'shop_id', 'name', 'tel', 'password', 'password_name', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}