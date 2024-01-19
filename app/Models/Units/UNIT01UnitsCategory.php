<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT01UnitsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01UnitsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsCategoryFactory::new();
    }

    protected $table = "unit01_units_categories";
    protected $fillable = ['slug', 'title', 'path_image', 'active', 'featured', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('unit01_units')->whereColumn('unit01_units.category_id', 'unit01_units_categories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('unit01_units')->whereColumn('unit01_units.category_id', 'unit01_units_categories.id');
        });
    }


}
