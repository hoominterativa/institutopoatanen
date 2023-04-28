<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD02ProductsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD02ProductsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02ProductsBannerFactory::new();
    }

    protected $table = "prod02_products_banners";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
