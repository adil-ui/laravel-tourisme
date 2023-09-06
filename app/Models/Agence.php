<?php

namespace App\Models;

use App\Models\Bookmark;
use App\Models\City;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Person
{
    use HasFactory;
    protected $fillable = [
        'price',
        'description',
        'link',
        'longitude',
        'latitude',
        'city_id'
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }

}
