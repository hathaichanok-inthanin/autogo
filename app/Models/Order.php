<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // เชื่อมกับสาขา
    public function shop() {
        return $this->belongsTo(Shop::class, 'branch_id');
    }

    // เชื่อมกับรายการสินค้า
    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}