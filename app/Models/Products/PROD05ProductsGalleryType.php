<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsGalleryTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsGalleryType extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsGalleryTypeFactory::new();
    }

    protected $table = "prod05_products_gallerytypes";
    protected $fillable = [
        "product_id",
        "color",
        "active",
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

    public function galleries()
    {
        return $this->hasMany(PROD05ProductsGallery::class, 'gallery_type_id', 'id')->sorting();
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
