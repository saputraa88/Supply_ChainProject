<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'temperature',
        'wind_speed',
        'rainfall',
        'humidity',
        'weather_code',
        'storm_risk',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}