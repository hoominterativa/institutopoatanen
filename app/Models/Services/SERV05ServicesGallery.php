<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesGalleryFactory::new();
    }

    protected $table = "serv05_services_galleries";
    protected $fillable = ['path_image_desktop', 'path_image_mobile', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
