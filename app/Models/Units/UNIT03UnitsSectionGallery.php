<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsSectionGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsSectionGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsSectionGalleryFactory::new();
    }

    protected $table = "unit03_units_sectiongalleries";
    protected $fillable = ['title', 'subtitle', 'active', 'unit_id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function unit()
    {
        return $this->belongsTo(UNIT03Units::class, 'unit_id');
    }
}
