<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD02V1ProductsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD02V1ProductsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02V1ProductsBannerFactory::new();
    }

    protected $table = "prod02v1_products_banners";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
