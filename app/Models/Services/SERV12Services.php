<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesFactory::new();
    }

    protected $table = "serv12_services";
    protected $fillable = ['category_id', 'slug', 'title', 'subtitle', 'description', 'text', 'path_image', 'path_image_icon', 'active', 'featured', 'sorting'];

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
        return $this->belongsTo(SERV12ServicesCategory::class, 'category_id');
    }
}
