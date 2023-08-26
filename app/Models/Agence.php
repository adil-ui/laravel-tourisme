<?php

namespace App\Models;

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
        'ville_id'
    ];

}
