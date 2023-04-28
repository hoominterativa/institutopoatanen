<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Products\PROD02ProductsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PROD02Products extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02ProductsFactory::new();
    }

    protected $table = "prod02_products";
    protected $fillable = [
        'title', 'description', 'subtitle', 'text', 'path_image_box', 'title_button', 'link_button', 'target_link_button', 'category_id', 'active', 'sorting', 'featured', 'slug'
    ];

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

    public function category()
    {
        return $this->belongsTo(PROD02ProductsCategory::class, 'category_id');
    }

    public function galleries()
    {
        return $this->hasMany(PROD02ProductsGallery::class, 'product_id');
    }
}
