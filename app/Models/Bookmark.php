<?php

namespace App\Models;

use App\Models\Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'picture',
        'price',
        'star',
        'description',
        'link',
        'longitude',
        'latitude',
        'city_id',
        'user_id',
        'created_at',
        'updated_at',

    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
