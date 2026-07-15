<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Port extends Model
{
    use HasFactory;

    // Keyword wajib menggunakan 'protected' dan kolom menggunakan bahasa Inggris sesuai database
    protected $fillable = [
        'country_id',
        'name',
        'code',
        'latitude',
        'longitude',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}