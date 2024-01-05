<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI102TopicsFeaturedTopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI102TopicsFeaturedTopics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI102TopicsFeaturedTopicsFactory::new();
    }

    protected $table = "topi102_topics_featuredtopics";
    protected $fillable = ['title', 'quantity', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
