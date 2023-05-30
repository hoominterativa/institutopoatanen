<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD02V1ProductsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD02V1ProductsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02V1ProductsGalleryFactory::new();
    }

    protected $table = "prod02v1_products_galleries";
    protected $fillable = ['product_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function product()
    {
        return $this->belongsTo(PROD02V1Products::class, 'product_id');
    }
}
