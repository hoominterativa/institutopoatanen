<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV10ServicesGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV10ServicesGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV10ServicesGalleryFactory::new();
    }

    protected $table = "serv10_services_galleries";
    protected $fillable = ['service_id','path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }


}
