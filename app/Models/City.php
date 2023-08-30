<?php

namespace App\Models;

use App\Models\Agence;
use App\Models\Guide;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];
    public function hotel()
    {
        return $this->hasMany(Hotel::class);
    }
    public function guide()
    {
        return $this->hasMany(Guide::class);
    }
    public function agence()
    {
        return $this->hasMany(Agence::class);
    }

}
