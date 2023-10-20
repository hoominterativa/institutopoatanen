<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsSectionFactory::new();
    }

    protected $table = "abou04_abouts_sections";
    protected $fillable = [
        //Section
        'title_section', 'subtitle_section', 'description_section', 'path_image_section', 'path_image_desktop_section', 'path_image_mobile_section', 'background_color_section',
        //Section Galleries
        'title_galleries', 'description_galleries', 'title_button_galleries', 'link_button_galleries', 'target_link_button_galleries',
        // Section Topics
        'path_image_desktop_topics', 'path_image_mobile_topics', 'background_color_topics',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner',
    ];

}
