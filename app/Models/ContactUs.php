<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
	protected $table = 'contact_us';

	protected $fillable = [
    	'name', 'tel', 'shop_id', 'comment'
    ];

    protected $primaryKey = 'id';
}