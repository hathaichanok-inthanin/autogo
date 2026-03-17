<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'address', 'tel', 'map_url', 'is_active', 'business_days', 'open_time', 'close_time',
    ];

    public function getWorkingHoursAttribute()
    {
        if(!$this->open_time || !$this->close_time) return '-';
        
        $open = \Carbon\Carbon::parse($this->open_time)->format('H:i');
        $close = \Carbon\Carbon::parse($this->close_time)->format('H:i');
        
        return "{$open} - {$close} น.";
    }
}