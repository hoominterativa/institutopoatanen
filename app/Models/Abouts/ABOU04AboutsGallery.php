<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsGalleryFactory::new();
    }

    protected $table = "abou04_abouts_galleries";
    protected $fillable = ['about_id', 'title', 'path_image', 'active', 'sorting', 'category_id'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(ABOU04AboutsCategory::class, 'category_id');
    }
}
