<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesGalleryCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesGalleryCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesGalleryCategoryFactory::new();
    }

    protected $table = "serv07_services_gallerycategories";
    protected $fillable = ['category_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function category()
    {
        return $this->belongsTo(SERV07ServicesCategory::class, 'category_id');
    }
}
