<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL03GalleriesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL03GalleriesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL03GalleriesSectionFactory::new();
    }

    protected $table = "gall03_galleries_sections";
    protected $fillable = [
        //Section Home
        'title_section', 'subtitle_section', 'active_section',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active_banner',
        //Section Content
        'title_content', 'subtitle_content', 'active_content',
    ];

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeActiveContent($query)
    {
        return $query->where('active_content', 1);
    }
}
