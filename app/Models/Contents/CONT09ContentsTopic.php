<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT09ContentsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT09ContentsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT09ContentsTopicFactory::new();
    }

    protected $table = "cont09_contents_topics";
    protected $fillable = [
        'content_id', 'link', 'link_target', 'path_image_icon', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
