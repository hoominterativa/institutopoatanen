<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12ServicesGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesGalleryFactory::new();
    }

    protected $table = "serv12_services_galleries";
    protected $fillable = ['service_id', 'description', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
