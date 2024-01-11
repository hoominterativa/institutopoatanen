<?php

namespace App\Models\Abouts;


use Illuminate\Database\Eloquent\Model;
use Database\Factories\Abouts\ABOU01AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ABOU01Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU01AboutsFactory::new();
    }

    protected $table = "abou01_abouts";
    protected $fillable = [
        //Abouts
        "slug",
        "title",
        "subtitle",
        "text",
        "path_image",
        "path_image_desktop",
        "path_image_mobile",
        "background_color",
        "active",
        "sorting",
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

    function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    function scopeActive($query)
    {
        return $query->where('active', 1);
    }

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

    function topics()
    {
        return $this->hasMany(ABOU01AboutsTopics::class, 'about_id')->active()->sorting();
    }
}
