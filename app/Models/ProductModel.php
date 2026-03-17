<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
	protected $table = 'models';

	protected $fillable = [
    	'brand_id', 'model_name', 'status', 'model_image'
    ];

	protected $casts = [
        'features' => 'array',
    ];

    protected $primaryKey = 'id';

    public function tireSpecs()
    {
        return $this->hasMany(TireSpec::class, 'model_id');
    }

    public function brand() 
    {
        return $this->belongsto(Brand::class);
    }
}