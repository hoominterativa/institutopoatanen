<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV04ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV04ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV04ServicesSectionFactory::new();
    }

    protected $table = "serv04_services_sections";
    protected $fillable = [
        'title_section', 'description_section', 'subtitle_section', 'path_image_section_desktop', 'path_image_section_mobile', 'background_color_section', 'active_section',
        'title_banner', 'description_banner', 'path_image_banner_desktop', 'path_image_banner_mobile', 'background_color_banner', 'active_banner',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
