<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesGalleryFactory::new();
    }

    protected $table = "serv09_services_galleries";
    protected $fillable = ['service_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
