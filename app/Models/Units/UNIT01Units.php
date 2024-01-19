<?php

namespace App\Models\Units;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Units\UNIT01UnitsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Units\UNIT01UnitsTopic;

class UNIT01Units extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsFactory::new();
    }

    protected $table = "unit01_units";
    protected $fillable = ['category_id', 'title_unit', 'title', 'description', 'featured', 'active', 'sorting'];

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

    public function topics()
    {
        return $this->hasMany(UNIT01UnitsTopic::class, 'unit_id')->active()->sorting();
    }

    public function galleries()
    {
        return $this->hasMany(UNIT01UnitsGallery::class, 'unit_id')->sorting();
    }

    public function category()
    {
        return $this->belongsTo(UNIT01UnitsCategory::class, 'category_id');
    }
}
