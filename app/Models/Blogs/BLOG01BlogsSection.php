<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG01BlogsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01BlogsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG01BlogsSectionFactory::new();
    }

    protected $table = "blog01_blogs_sections";
    protected $fillable = [
        //Section
        "title_section", "subtitle_section", "description_section", 'active_section',
        //Banner
        'title_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
        //General
        "sorting",
    ];

    function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
