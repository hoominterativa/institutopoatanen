<?php

namespace App\Models\WorkWith;

use Database\Factories\WorkWith\WOWI01WorkWithFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WOWI01WorkWith extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return WOWI01WorkWithFactory::new();
    }

    protected $table = "wowi01_workwith";
    protected $fillable = [
        "title_banner",
        "path_image_banner",
        "title_box",
        "title",
        "subtitle",
        "slug",
        "description",
        "text",
        "path_image_icon",
        "path_image_thumbnail",
        "title_content",
        "subtitle_content",
        "description_content",
        "path_image_content",
        "link_content",
        "link_target_content",
        "featured_menu",
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

    public function scopeFeatured($query)
    {
        return $query->where('featured_menu', 1);
    }
}
