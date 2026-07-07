<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'base_currency',
        'target_currency',
        'rate',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}