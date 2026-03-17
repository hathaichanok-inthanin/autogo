<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
	protected $table = 'cart_items';

	protected $fillable = [
    	'user_id', 'session_id', 'product_id', 'quantity'
    ];

	public function product()
    {
        return $this->belongsTo(ProductTire::class);
    }

    protected $primaryKey = 'id';
}