<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'picture',
        'status',
        'created_at',
        'updated_at'
    ];
}
