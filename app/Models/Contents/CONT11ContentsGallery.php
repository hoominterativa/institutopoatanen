<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT11ContentsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT11ContentsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT11ContentsGalleryFactory::new();
    }

    protected $table = "cont11_contents_galleries";
    protected $fillable = ['content_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
