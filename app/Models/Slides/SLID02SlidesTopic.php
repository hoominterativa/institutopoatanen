<?php

namespace App\Models\Slides;

use Database\Factories\Slides\SLID02SlidesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID02SlidesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID02SlidesTopicFactory::new();
    }

    protected $table = "slid02_slides_topics";
    protected $fillable = [
        'link', 'target_link', 'path_image_icon', 'active', 'sorting',
    ];

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
