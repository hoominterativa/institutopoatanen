<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05UnitsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsGalleryFactory::new();
    }

    protected $table = "unit05_units_galleries";
    protected $fillable = ["path_image", "sorting"];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
