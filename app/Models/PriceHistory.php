<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
	protected $guarded = [];
    
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class, 'updated_by_user_id');
    }
}