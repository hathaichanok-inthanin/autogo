<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table = 'admin';

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'username', 'password', 'password_name', 'role', 'status', 'last_active_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];

    public function isOnline()
    {
        return $this->last_active_at && $this->last_active_at->diffInMinutes(now()) < 5;
    }

}