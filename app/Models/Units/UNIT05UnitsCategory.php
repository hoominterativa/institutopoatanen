<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05UnitsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsCategoryFactory::new();
    }

    protected $table = "unit05_units_categories";
    protected $fillable = ['slug', 'title', 'active', 'featured', 'sorting'];

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

    public function units()
    {
        return $this->hasMany(UNIT05Units::class, 'category_id')->active()->sorting();
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('unit05_units')->whereColumn('unit05_units.category_id', 'unit05_units_categories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('unit05_units')->whereColumn('unit05_units.category_id', 'unit05_units_categories.id');
        });
    }

    public function getRelationCore()
    {
        return $this->belongsToMany(UNIT05UnitsSubcategory::class, 'unit05_units','category_id','subcategory_id')->groupBy('category_id');
    }
    
    // public function UNIT05UnitsSubcategories()
    // {
    //     return $this->belongsToMany(UNIT05UnitsSubcategory::class, 'unit05_units','category_id','subcategory_id')->groupBy('category_id');
    // }


}
