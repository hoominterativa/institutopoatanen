<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsSubcategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsSubcategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsSubcategoryFactory::new();
    }

    protected $table = "prod05_products_subcategories";
    protected $fillable = [
        "title",
        "path_image_icon",
        "active",
        "sorting",
        "slug",
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
