<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesSectionFactory::new();
    }

    protected $table = "serv09_services_sections";
    protected $fillable = [
        //Section Home
        'title', 'subtitle', 'description', 'active',
        //Section Banner
        'title_banner', 'subtitle_banner', 'active_banner', 'path_image_desktop', 'path_image_mobile', 'background_color',
        //Section Feedback
        'title_feedback', 'active_feedback'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
