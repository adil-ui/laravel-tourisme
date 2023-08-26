<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'picture',
        "role",
        'status',
        'created_at',
        'updated_at'
    ];
}