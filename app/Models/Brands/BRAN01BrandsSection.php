<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN01BrandsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN01BrandsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN01BrandsSectionFactory::new();
    }

    protected $table = "bran01_brands_sections";
    protected $fillable = [
        'title_banner', 'subtitle_banner', 'path_image_banner_desktop', 'path_image_banner_mobile', 'background_color_banner', 'active_banner',
        'title_section', 'subtitle_section', 'path_image_section_desktop', 'path_image_section_mobile', 'background_color_section', 'active_section', 'description_section'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
