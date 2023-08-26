<?php

namespace App\Models;

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
        'ville_id',
    ];
}
