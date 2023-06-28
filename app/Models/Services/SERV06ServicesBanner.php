<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV06ServicesBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV06ServicesBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV06ServicesBannerFactory::new();
    }

    protected $table = "serv06_services_banners";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active',];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
