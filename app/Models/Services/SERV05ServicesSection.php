<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesSectionFactory::new();
    }

    protected $table = "serv05_services_sections";
    protected $fillable =
    [
        //Home
        'title', 'description', 'subtitle', 'active',

        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'active_banner',

        //About
        'title_about', 'subtitle_about', 'description_about', 'active_about',

    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeActiveAbout($query)
    {
        return $query->where('active_about', 1);
    }
}
