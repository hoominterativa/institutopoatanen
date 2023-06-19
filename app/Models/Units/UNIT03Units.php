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
    protected $fillable = ['category_id', 'title', 'slug', 'path_image', 'path_image_icon',  'path_image_gallery', 'active', 'sorting', 'title_show', 'subtitle_show', 'path_image_icon_show','title_gallery', 'link_video'];

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

    public function socials()
    {
        return $this->hasMany(UNIT03UnitsSocial::class, 'unit_id');
    }

    public function banners()
    {
        return $this->hasMany(UNIT03UnitsBannerShow::class, 'unit_id');
    }

    public function content()
    {
        return $this->hasMany(UNIT03UnitsContent::class, 'unit_id');
    }

    public function gallery()
    {
        return $this->hasMany(UNIT03UnitsGallery::class, 'unit_id');
    }
    public function section()
    {
        return $this->hasMany(UNIT03UnitsSectionGallery::class, 'unit_id');
    }
}
