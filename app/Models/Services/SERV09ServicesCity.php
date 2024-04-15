<?php

namespace App\Models\Services;

use Database\Factories\SERV09ServicesCityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesCity extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesCityFactory::new();
    }

    protected $table = "";
    protected $fillable = [];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
