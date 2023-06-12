<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL03GalleriesBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL03GalleriesBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL03GalleriesBannerFactory::new();
    }

    protected $table = "gall03_galleries_banners";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
