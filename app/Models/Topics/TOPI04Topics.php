<?php

namespace App\Models\Topics;


use Illuminate\Database\Eloquent\Model;
use App\Models\Topics\TOPI04TopicsTopicSection;
use Database\Factories\Topics\TOPI04TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TOPI04Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI04TopicsFactory::new();
    }

    protected $table = "topi04_topics";
    protected $fillable = ['title_topic', 'title', 'subtitle', 'description', 'path_image', 'title_button', 'link_button', 'target_link_button', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getRelationCore()
    {
        return null;
    }

    public function topicSection()
    {
        return $this->hasMany(TOPI04TopicsTopicSection::class, 'topic_id');
    }
}
