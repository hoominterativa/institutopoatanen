<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Products\PROD02V1ProductsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PROD02V1Products extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02V1ProductsFactory::new();
    }

    protected $table = "prod02v1_products";
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
        return $this->belongsTo(PROD02V1ProductsCategory::class, 'category_id');
    }

    public function galleries()
    {
        return $this->hasMany(PROD02V1ProductsGallery::class, 'product_id');
    }
}
