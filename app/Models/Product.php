<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

use App\Models\TireSpec;
use App\Models\PriceHistory;

class Product extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'products';

	protected $fillable = [
    	'brand_id', 'model_id', 'sku', 'product_type', 'name', 'slug', 'price', 'cost_price', 'sale_price', 'is_active', 'is_featured'
    ];

	protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $primaryKey = 'id';

    public function tireSpec() {
        return $this->hasOne(TireSpec::class);
    }

    public function priceHistories(){
        return $this->hasMany(PriceHistory::class)->orderBy('created_at', 'desc');
    }

    public function getRealPriceAttribute(){
        if ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function isTire(){
        return $this->product_type === 'tire';
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function model() {
        return $this->belongsTo(ProductModel::class, 'model_id');
    }
}