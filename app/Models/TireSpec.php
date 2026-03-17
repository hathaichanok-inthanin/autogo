<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProductModel;
use App\Models\Brand;
use App\Models\Product;

class TireSpec extends Model
{
	protected $guarded = [];
    public $timestamps = false;
    
    public function product() {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'features' => 'array',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function model(){
        return $this->belongsTo(ProductModel::class, 'model_id', 'id');
    }
}