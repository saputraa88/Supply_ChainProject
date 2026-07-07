<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'title',
        'description',
        'url',
        'sentiment',
        'published_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}