<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
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
