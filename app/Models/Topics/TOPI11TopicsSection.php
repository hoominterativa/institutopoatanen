<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI11TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI11TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI11TopicsSectionFactory::new();
    }

    protected $table = "topi11_topics_sections";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'path_image',
        'active',
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
