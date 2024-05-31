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
    protected $fillable = ['category_id', 'subcategory_id', 'slug', 'title', 'subtitle', 'description', 'text', 'path_image_icon', 'path_image_box', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(UNIT05UnitsCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(UNIT05UnitsSubcategory::class, 'subcategory_id');
    }

    public function links()
    {
        return $this->hasMany(UNIT05UnitsLink::class, 'unit_id')->active()->sorting()->limit(2);
    }
}
