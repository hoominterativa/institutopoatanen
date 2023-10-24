<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG03BlogsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG03BlogsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG03BlogsSectionFactory::new();
    }

    protected $table = "blog03_blogs_sections";
    protected $fillable = [
        //Section
        'title_section', 'subtitle_section', 'description_section', 'active_section',
        //Banner
        'title_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner'
    ];

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
