<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV08ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV08ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV08ServicesSectionFactory::new();
    }

    protected $table = "serv08_services_sections";
    protected $fillable = [
        //Section Home
        'title', 'subtitle', 'description', 'active',
        //Section Banner
        'title_banner', 'subtitle_banner', 'description_banner', 'active_banner', 'path_image_desktop', 'path_image_mobile',
        //Section Content
        'title_content', 'subtitle_content', 'description_content', 'active_content',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
