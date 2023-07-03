<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PROD05Products extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return PROD05ProductsFactory::new();
    }

    protected $table = "prod05_products";
    protected $fillable = [
        "category_id",
        "subcategory_id",
        "slug",
        "title",
        "subtitle",
        "description",
        "text",
        "path_image_thumbnail",
        "path_image",
        "link",
        "link_target",
        "title_button",
        "path_image_banner",
        "path_image_banner_mobile",
        "title_banner",
        "subtitle_banner",
        "title_section_topic",
        "subtitle_section_topic",
        "featured_home",
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

    public function scopeFeaturedHome($query)
    {
        return $query->where('featured_home', 1);
    }

    public function category()
    {
        return $this->belongsTo(PROD05ProductsCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(PROD05ProductsSubcategory::class, 'subcategory_id');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
