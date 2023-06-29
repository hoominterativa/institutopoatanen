<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsGalleryFactory::new();
    }

    protected $table = "prod05_products_galleries";
    protected $fillable = [
        "gallery_type_id",
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

    public function color()
    {
        return $this->belongsTo(PROD05ProductsGalleryType::class, 'gallery_type_id');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
