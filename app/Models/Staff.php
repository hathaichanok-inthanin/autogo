<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use Notifiable;
    protected $table = 'staffs';

    protected $guard = 'staff';

    protected $fillable = [
        'partner_id', 'name', 'username', 'password', 'password_name', 'role', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function partner() {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

}