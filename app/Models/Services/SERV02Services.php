<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV02ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV02Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV02ServicesFactory::new();
    }

    protected $table = "serv02_services";
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'text',
        'path_image_desktop',
        'path_image_mobile',
        'background_color',
        'active',
        'featured',
        'title_box',
        'description_box',
        'path_image_box',
        'path_image_icon_box',
        'title_button',
        'link_button',
        'target_link_button',
        'title_banner',
        'path_image_desktop_banner',
        'path_image_mobile_banner',
        'background_color_banner',
        'active_banner',
        'title_section',
        'subtitle_section',
        'description_section',
        'active_section',
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
