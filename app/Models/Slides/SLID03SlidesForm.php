<?php

namespace App\Models\Slides;

use Database\Factories\Slides\SLID03SlidesFormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID03SlidesForm extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID03SlidesFormFactory::new();
    }

    protected $table = "slid03_slides_forms";
    protected $fillable = [
        "title",
        "title_lightbox",
        "description_lightbox",
        "path_image_lightbox",
        "inputs",
        "inputs_additionals",
        "active",
        "sorting",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
