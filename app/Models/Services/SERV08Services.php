<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV08ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV08Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV08ServicesFactory::new();
    }

    protected $table = "serv08_services";
    protected $fillable = [
        'category_id', 'title', 'subtitle', 'description', 'title_price', 'price', 'title_button',
        'link_button', 'target_link', 'title_featured_service', 'color_featured_service', 'featured_service', 'path_image',
        'active', 'sorting', 'slug', 'featured', 'text',
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

    public function scopeFeaturedService($query)
    {
        return $query->where('featured_service', 1);
    }

    public function categories()
    {
        return $this->belongsTo(SERV08ServicesCategory::class, 'category_id');
    }
}
