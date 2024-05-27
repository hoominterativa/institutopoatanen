<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05Units extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsFactory::new();
    }

    protected $table = "unit05_units";
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
