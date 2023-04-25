<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT01UnitsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01UnitsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsGalleryFactory::new();
    }

    protected $table = "unit01_units_galleries";
    protected $fillable = ['unit_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
