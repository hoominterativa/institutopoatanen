<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG01BlogsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01Blogs extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG01BlogsFactory::new();
    }

    protected $table = "blog01_blogs";
    protected $fillable = [
        "category_id",
        "title",
        "slug",
        "publishing",
        "description",
        "text",
        "path_image_thumbnail",
        "path_image_icon",
        "path_image",
        "active",
        "featured_home",
        "featured_page",
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

    public function scopeFeaturedPage($query)
    {
        return $query->where('featured_page', 1);
    }

    public function scopeFeaturedHome($query)
    {
        return $query->where('featured_home', 1);
    }

    public function category()
    {
        return $this->belongsTo(BLOG01BlogsCategory::class, 'category_id');
    }
}
