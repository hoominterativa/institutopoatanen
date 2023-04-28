<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD02ProductsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD02ProductsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02ProductsGalleryFactory::new();
    }

    protected $table = "prod02_products_galleries";
    protected $fillable = ['product_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function product()
    {
        return $this->belongsTo(PROD02Products::class, 'product_id');
    }
}
