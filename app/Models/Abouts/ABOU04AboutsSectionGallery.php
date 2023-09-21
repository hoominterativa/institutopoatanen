<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsSectionGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsSectionGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsSectionGalleryFactory::new();
    }

    protected $table = "abou04_abouts_sectiongalleries";
    protected $fillable = ['title', 'description', 'title_button', 'link_button', 'target_link_button', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
