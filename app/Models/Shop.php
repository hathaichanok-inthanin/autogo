<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'shops'; 

    protected $fillable = [
        'shop_name',
        'shop_image',
        'branch_name',
        'phone',
        'email',
        'password',
        'google_maps_link',
        'latitude',
        'longitude',
        'address_text',
        'subdistrict',
        'district',
        'province',
        'zipcode',
        'business_days',
        'open_time',
        'close_time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];
}