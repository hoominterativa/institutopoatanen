<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesBannerFactory::new();
    }

    protected $table = "serv07_services_banners";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
