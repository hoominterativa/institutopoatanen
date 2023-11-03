<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT13ContentsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT13ContentsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT13ContentsTopicFactory::new();
    }

    protected $table = "cont13_contents_topics";
    protected $fillable = ['path_image', 'link', 'target_link', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
