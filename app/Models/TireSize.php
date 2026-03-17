<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TireSize extends Model
{
	protected $table = 'tire_sizes';

	protected $fillable = [
    	'width', 'ratio', 'rim', 'size'
    ];

    protected $primaryKey = 'id';
	
}