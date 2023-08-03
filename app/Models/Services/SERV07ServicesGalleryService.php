<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesGalleryServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesGalleryService extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesGalleryServiceFactory::new();
    }

    protected $table = "serv07_services_galleryservices";
    protected $fillable = ['service_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

   public function service()
   {
        return $this->belongsTo(SERV07Services::class, 'service_id');
   }
}
