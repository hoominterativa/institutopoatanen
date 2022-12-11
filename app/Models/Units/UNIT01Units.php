<?php

namespace App\Models\Units;

use Database\Factories\UNIT01UnitsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01Units extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsFactory::new();
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
