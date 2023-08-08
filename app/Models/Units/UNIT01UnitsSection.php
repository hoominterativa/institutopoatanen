<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT01UnitsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01UnitsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsSectionFactory::new();
    }

    protected $table = "unit01_units_sections";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
