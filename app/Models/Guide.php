<?php

namespace App\Models;

use App\Models\City;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Person
{
    use HasFactory;
    protected $fillable = [
        'link',
        'longitude',
        'description',
        'latitude',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
