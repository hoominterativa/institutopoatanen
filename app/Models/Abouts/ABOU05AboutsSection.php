<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU05AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU05AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU05AboutsSectionFactory::new();
    }

    protected $table = "abou05_abouts_sections";
    protected $fillable = [
        //Section
        'title_section', 'subtitle_section', 'description_section', 'path_image_desktop_section', 'path_image_mobile_section', 'background_color_section',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner',
        //Section Content
        'title_content', 'subtitle_content',
    ];
}
