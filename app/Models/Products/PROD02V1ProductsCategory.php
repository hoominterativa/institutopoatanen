<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD02V1ProductsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD02V1ProductsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02V1ProductsCategoryFactory::new();
    }

    protected $table = "prod02v1_products_categories";
    protected $fillable = ['title', 'slug', 'path_image_icon', 'active', 'featured', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('prod02v1_products')->whereColumn('prod02v1_products.category_id', 'prod02v1_products_categories.id');
        });
    }


}
