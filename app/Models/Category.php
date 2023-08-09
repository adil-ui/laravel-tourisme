<?php

namespace App\Models;

use App\Models\Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'picture',
        'created_at',
        'updated_at'
    ];
    public function information()
    {
        return $this->hasMany(Information::class);
    }
}
