<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsCategoryFactory::new();
    }

    protected $table = "unit03_units_categories";
    protected $fillable = ['title', 'slug', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('unit03_units')->whereColumn('unit03_units.category_id', 'unit03_units_categories.id');
        });
    }

    
}
