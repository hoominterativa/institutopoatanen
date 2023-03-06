<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI102TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI102TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI102TopicsSectionFactory::new();
    }

    protected $table = "topi102_topics_sections'";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'active', 'sorting'];

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
