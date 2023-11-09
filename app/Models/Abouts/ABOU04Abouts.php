<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsFactory::new();
    }

    protected $table = "abou04_abouts";
    protected $fillable = [
        'slug', 'title', 'subtitle', 'text', 'path_image', 'active', 'sorting',
        //Section Galleries
        'title_galleries', 'description_galleries', 'title_button_galleries', 'link_button_galleries', 'target_link_button_galleries', 'active_galleries',
        // Section Topics
        'path_image_desktop_topics', 'path_image_mobile_topics', 'background_color_topics', 'active_topics',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    function scopeActiveTopics($query)
    {
        return $query->where('active_topics', 1);
    }

    function scopeActiveGalleries($query)
    {
        return $query->where('active_galleries', 1);
    }
}
