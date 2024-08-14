<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesSectionFactory::new();
    }

    protected $table = "serv07_services_sections";
    protected $fillable = [
        //Section
        'title', 'description', 'subtitle', 'active',
        //Banner
        'title_banner', 'path_image_desktop', 'path_image_mobile', 'active_banner'
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
