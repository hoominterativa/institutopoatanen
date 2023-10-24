<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsSectionFactory::new();
    }

    protected $table = "abou02_abouts_sections";
    protected $fillable = [
        //Section home
        'title_section', 'description_section', 'subtitle_section', 'active_section',
        //Banner
        'title_banner', 'subtitle_banner', 'background_color_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'active_banner',
        //Section topics
        'title_topics', 'subtitle_topics', 'active_topic',
        //Content
        'title_content', 'subtitle_content', 'description_content', 'path_image_content', 'title_button_content', 'link_button_content', 'target_link_button_content', 'path_image_desktop_content', 'path_image_mobile_content', 'background_color_content', 'active_content',
    ];

    function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    function scopeActiveTopic($query)
    {
        return $query->where('active_topic', 1);
    }

    function scopeActiveContent($query)
    {
        return $query->where('active_content', 1);
    }


}
