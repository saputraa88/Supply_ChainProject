<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicData extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'year',
        'gdp',
        'inflation',
        'exports',
        'imports',
        'population',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}