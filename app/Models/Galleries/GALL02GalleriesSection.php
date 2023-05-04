<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL02GalleriesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL02GalleriesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL02GalleriesSectionFactory::new();
    }

    protected $table = "gall02_galleries_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
