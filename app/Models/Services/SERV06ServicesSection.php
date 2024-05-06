<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV06ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV06ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV06ServicesSectionFactory::new();
    }

    protected $table = "serv06_services_sections";
    protected $fillable = [
        //Section
        'title_section', 'subtitle_section', 'description_section', 'path_image_section', 'active_section',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'active_banner'
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
