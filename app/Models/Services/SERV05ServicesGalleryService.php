<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesGalleryServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesGalleryService extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesGalleryServiceFactory::new();
    }

    protected $table = "serv05_services_galleryservices";
    protected $fillable = ['service_id', 'path_image_desktop', 'path_image_mobile', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function service()
    {
        return $this->belongsTo(SERV05Services::class, 'service_id');
    }
}
