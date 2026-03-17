<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TirePromotionSalePrice extends Model
{
	protected $table = 'tire_promotion_sale_prices';

	protected $fillable = [
    	'tire_id', 'promotion_sale_price',
    ];

    protected $primaryKey = 'id';
}