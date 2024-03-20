<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesFactory::new();
    }

    protected $table = "serv05_services";
    protected $fillable = [
        // Service
        'category_id', 'slug', 'title', 'description', 'subtitle', 'title_price', 'path_image', 'path_image_icon', 'price', 'featured', 'active', 'sorting',
        //Topic
        'title_topic', 'subtitle_topic', 'title_topic_button', 'link_topic', 'target_link','active_topic',
        //About
        'title_about_inner', 'subtitle_about_inner', 'description_about_inner', 'active_about_inner',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop', 'path_image_mobile', 'active_banner',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeActiveTopic($query)
    {
        return $query->where('active_topic', 1);
    }

    public function scopeActiveAboutInner($query)
    {
        return $query->where('active_about_inner', 1);
    }

    public function scopeActiveBannerInner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function category()
    {
        return $this->belongsTo(SERV05ServicesCategory::class, 'category_id');
    }
}
