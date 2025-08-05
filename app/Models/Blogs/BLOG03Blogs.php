<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG03BlogsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG03Blogs extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG03BlogsFactory::new();
    }

    protected $table = "blog03_blogs";
    protected $fillable = [
        "category_id",
        "title",
        "slug",
        "publishing",
        "description",
        "text",
        "path_image",
        "path_image_box",
        "active",
        "featured",
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

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
    public function galleries()
    {
        return $this->hasMany(BLOG03BlogsGalleries::class, 'blog_id');
    }
    public function galleriesActive()
    {
        return $this->hasMany(BLOG03BlogsGalleries::class, 'blog_id')->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(BLOG03BlogsCategory::class, 'category_id');
    }
}
