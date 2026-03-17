<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	protected $table = 'brands';

	protected $fillable = [
    	'brand_name', 'slug', 'brand_image', 'status'
    ];

    protected $primaryKey = 'id';

	public function tireSpecs()
    {
        return $this->hasMany(TireSpec::class, 'brand_id');
    }
}