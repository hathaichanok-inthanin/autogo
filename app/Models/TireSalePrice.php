<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TireSalePrice extends Model
{
	protected $table = 'tire_sale_prices';

	protected $fillable = [
    	'tire_id', 'sale_price',
    ];

    protected $primaryKey = 'id';
}