<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsGalleryFactory::new();
    }

    protected $table = "unit03_units_galleries";
    protected $fillable = ['title', 'unit_id', 'link_video', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function unit()
    {
        return $this->belongsTo(UNIT01Units::class, 'unit_id');
    }
}
