<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL03GalleriesSectionGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL03GalleriesSectionGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL03GalleriesSectionGalleryFactory::new();
    }

    protected $table = "gall03_galleries_sectiongalleries";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
