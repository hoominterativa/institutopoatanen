<?php

namespace App\Models\Slides;

use Database\Factories\Slides\SLID02SlidesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID02Slides extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID02SlidesFactory::new();
    }

    protected $table = "slid02_slides";
    protected $fillable = ['path_image_desktop', 'link', 'target_link', 'active', 'path_image_mobile', 'link_mobile', 'target_link_mobile', 'active_mobile', 'sorting',];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
