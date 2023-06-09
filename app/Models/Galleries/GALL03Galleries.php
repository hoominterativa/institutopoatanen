<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL03GalleriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL03Galleries extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL03GalleriesFactory::new();
    }

    protected $table = "gall03_galleries";
    protected $fillable = ['title', 'path_image', 'active', 'featured', 'sorting', 'image_legend'];

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

    public function images()
    {
        return $this->hasMany(GALL03GalleriesImage::class, 'gallery_id');
    }
}
