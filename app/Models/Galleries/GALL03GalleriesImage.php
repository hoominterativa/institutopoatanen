<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL03GalleriesImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL03GalleriesImage extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL03GalleriesImageFactory::new();
    }

    protected $table = "gall03_galleries_images";
    protected $fillable = ['path_image', 'gallery_id', 'sorting'];

    public function gallery()
    {
        return $this->belongsTo(GALL03Galleries::class, 'gallery_id');
    }
}
