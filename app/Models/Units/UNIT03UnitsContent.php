<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsContentFactory::new();
    }

    protected $table = "unit03_units_contents";
    protected $fillable = ['unit_id', 'title', 'subtitle', 'text', 'title_button', 'link_button', 'target_link_button', 'path_image', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function unit()
    {
        return $this->belongsTo(UNIT01Units::class, 'unit_id');
    }

    public function gallery()
    {
        return $this->hasMany(UNIT03UnitsGalleryContent::class, 'content_id');
    }
}
