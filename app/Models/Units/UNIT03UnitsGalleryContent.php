<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsGalleryContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsGalleryContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsGalleryContentFactory::new();
    }

    protected $table = "unit03_units_gallerycontents";
    protected $fillable = ['content_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function content()
    {
        return $this->belongsTo(UNIT03UnitsContent::class, 'content_id');
    }
}
