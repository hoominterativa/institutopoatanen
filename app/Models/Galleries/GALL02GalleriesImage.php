<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL02GalleriesImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL02GalleriesImage extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL02GalleriesImageFactory::new();
    }

    protected $table = "gall02_galleries_images";
    protected $fillable = ['gallery_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function galleries()
    {
        return $this->belongsTo(GALL02Galleries::class, 'gallery_id');
    }
}
