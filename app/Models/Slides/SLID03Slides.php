<?php

namespace App\Models\Slides;

use Database\Factories\Slides\SLID03SlidesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID03Slides extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID03SlidesFactory::new();
    }

    protected $table = "slid03_slides";
    protected $fillable = [
        "description",
        "path_image_desktop",
        "path_image_mobile",
        "title_button",
        "link",
        "target_link",
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
