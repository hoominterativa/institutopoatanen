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
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeaturedHome($query)
    {
        return $query->where('featured_home', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
