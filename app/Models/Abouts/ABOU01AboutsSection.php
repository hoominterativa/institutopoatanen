<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU01AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU01AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU01AboutsSectionFactory::new();
    }

    protected $table = "abou01_abouts_sections";
    protected $fillable = [
        //Section home
        "title_section",
        "subtitle_section",
        "description_section",
        "path_image_section_desktop",
        "path_image_section_mobile",
        "background_color_section",
        "active_section",
        //Banner
        "title_banner",
        "subtitle_banner",
        "path_image_banner_desktop",
        "path_image_banner_mobile",
        "background_color_banner",
        "active_banner",
        //Section topic
        "path_image_topic_desktop",
        "path_image_topic_mobile",
        "background_color_topic",
        //Content
        "title_content",
        "subtitle_content",
        "text_content",
        "background_color_content",
        "path_image_content_desktop",
        "path_image_content_mobile",
        "path_image_content",
        "title_button_content",
        "link_button_content",
        "target_link_button_content",
        "active_content",
    ];

    function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    function scopeActiveContent($query)
    {
        return $query->where('active_content', 1);
    }
}
