<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesFactory::new();
    }

    protected $table = "serv07_services";
    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'subtitle',
        'description',
        'text',
        'path_image',
        'path_image_box',
        'title_button',
        'link_button',
        'target_link_button',
        'active',
        'sorting',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(SERV07ServicesCategory::class, 'category_id');
    }

    public function galleries()
    {
        return $this->hasMany(SERV07ServicesGallery::class, 'service_id');
    }
}
