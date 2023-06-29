<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsGallerySectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsGallerySection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsGallerySectionFactory::new();
    }

    protected $table = "prod05_products_gallerysections";
    protected $fillable = [
        "product_id",
        "path_image",
        "link_video",
        "sorting",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
