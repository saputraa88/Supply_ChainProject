<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'capital',
        'region',
        'currency',
        'currency_symbol',
        'latitude',
        'longitude',
        'flag',
        'population',
    ];

    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    public function economicData()
    {
        return $this->hasMany(EconomicData::class);
    }

    public function weatherLogs()
    {
        return $this->hasMany(WeatherLog::class);
    }

    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class);
    }

    public function newsCaches()
    {
        return $this->hasMany(NewsCache::class);
    }

    public function riskScores()
    {
        return $this->hasMany(RiskScore::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
    public function watchedByUsers()
{
    return $this->belongsToMany(\App\Models\User::class, 'watchlists')->withTimestamps();
}
}