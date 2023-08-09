<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'address',
        'phone',
        'link',
        'picture',
        'status',
        'longitude',
        'latitude',
        'ville_id',
        'created_at',
        'updated_at'
    ];
}
