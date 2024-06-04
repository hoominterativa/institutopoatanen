<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsSubcategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05UnitsSubcategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsSubcategoryFactory::new();
    }

    protected $table = "unit05_units_subcategories";
    protected $fillable = ['slug', 'title', 'description', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function units()
    {
        return $this->hasMany(UNIT05Units::class, 'subcategory_id')->active()->sorting();
    }

    public static function getSubCategoryByCategory($category)
    {
        return self::whereHas('units', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->exists()->active()->sorting()->get();
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('unit05_units')->whereColumn('unit05_units.subcategory_id', 'unit05_units_subcategories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('unit05_units')->whereColumn('unit05_units.subcategory_id', 'unit05_units_subcategories.id');
        });
    }
}
