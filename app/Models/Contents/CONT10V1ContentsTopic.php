<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10V1ContentsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10V1ContentsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10V1ContentsTopicFactory::new();
    }

    protected $table = "cont10v1_contents_topics";
    protected $fillable = ['content_id', 'date',  'locale', 'title_button', 'link_button', 'link_target_button', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
