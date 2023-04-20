<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI04TopicsTopicSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI04TopicsTopicSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI04TopicsTopicSectionFactory::new();
    }

    protected $table = "topi04_topics_topicsections";
    protected $fillable = ['topic_id', 'title', 'path_image_icon', 'path_image_box', 'active', 'sorting'];

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
