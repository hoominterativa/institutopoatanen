<?php

namespace App\Models\Slides;

use Database\Factories\Slides\SLID02SlidesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID02SlidesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID02SlidesSectionFactory::new();
    }

    protected $table = "slid02_slides_sections";
    protected $fillable = ['path_image_background', 'colors', 'active',];


    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
