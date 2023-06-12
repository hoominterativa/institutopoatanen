<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03Units extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsFactory::new();
    }

    protected $table = "unit03_units";
    protected $fillable = ['category_id', 'title', 'slug', 'path_image', 'path_image_icon', 'active', 'sorting'];

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
        return $this->belongsTo(UNIT03UnitsCategory::class, 'category_id');
    }

    public function topic()
    {
        return $this->hasMany(UNIT03UnitsTopic::class, 'unit_id');
    }

    public function social()
    {
        return $this->hasMany(UNIT03UnitsSocial::class, 'unit_id');
    }
}
