<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02AboutsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsBannerFactory::new();
    }

    protected $table = "abou02_abouts_banners";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
