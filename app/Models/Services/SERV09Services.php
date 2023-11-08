<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesFactory::new();
    }

    protected $table = "serv09_services";
    protected $fillable = [
        'category_id', 'title', 'subtitle', 'description', 'price', 'path_image', 'title_info', 'informations', 'active', 'sorting', 'slug', 'featured', 'text', 'link',
        //Banner Inner
        'title_banner', 'subtitle_banner', 'active_banner', 'path_image_desktop', 'path_image_mobile', 'background_color',
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
        return $this->belongsTo(SERV09ServicesCategory::class, 'category_id');
    }

    public function topics()
    {
        return $this->hasMany(SERV09ServicesTopic::class, 'service_id');
    }
}
