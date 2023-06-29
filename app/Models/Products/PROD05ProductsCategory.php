<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsCategoryFactory::new();
    }

    protected $table = "prod05_products_categories";
    protected $fillable = [
        "title",
        "path_image_icon",
        "title_section",
        "subtitle_section",
        "description_section",
        "featured_home",
        "active",
        "sorting",
        "slug",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('prod05_products_categories.sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('prod05_products_categories.active', 1);
    }

    public function scopeFeaturedHome($query)
    {
        return $query->where('prod05_products_categories.featured_home', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('prod05_products_categories.id')->from('prod05_products')->whereColumn('prod05_products.category_id', 'prod05_products_categories.id');
        });
    }

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('prod05_products_categories.id')->from('prod05_products')->whereColumn('prod05_products.category_id', 'prod05_products_categories.id');
        });
    }

    public function pROD05ProductsSubcategories()
    {
        return $this->belongsToMany(PROD05ProductsSubcategory::class, 'prod05_products','category_id','subcategory_id')->groupBy('category_id');
    }

    public function getRelationCore()
    {
        return $this->belongsToMany(PROD05ProductsSubcategory::class, 'prod05_products','category_id','subcategory_id')->groupBy('category_id');
    }
}
