<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG01BlogsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01BlogsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG01BlogsBannerFactory::new();
    }

    protected $table = "blog01_blogs_banners";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
