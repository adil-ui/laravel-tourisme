<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'picture',
        'description',
        'category_id',
        'created_at',
        'updated_at'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
