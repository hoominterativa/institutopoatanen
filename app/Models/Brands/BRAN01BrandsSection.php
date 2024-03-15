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
        //Section
        'title_section', 'subtitle_section', 'active_section', 'description_section',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'active_banner',
        //Content
        'title_content', 'subtitle_content', 'active_content', 'description_content',
    ];

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }
}
