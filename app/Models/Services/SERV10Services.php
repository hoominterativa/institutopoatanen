<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV10ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV10Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV10ServicesFactory::new();
    }

    protected $table = "serv10_services";
    protected $fillable = [
        //Services
        'category_id', 'slug', 'title', 'text', 'path_image', 'title_box', 'description_box', 'path_image_icon_box', 'path_image_box', 'featured', 'active', 'sorting',
        //Show page
        'title_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
        'title_content', 'subtitle_content', 'description_content', 'active_content',
        'title_topic', 'subtitle_topic', 'description_topic', 'active_topic',
        'title_gallery', 'description_gallery', 'active_gallery',

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

    public function categories()
    {
        return $this->belongsTo(SERV10ServicesCategory::class, 'category_id');
    }
}
