<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG03BlogsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG03BlogsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG03BlogsBannerFactory::new();
    }

    protected $table = "blog03_blogs_banners";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

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
