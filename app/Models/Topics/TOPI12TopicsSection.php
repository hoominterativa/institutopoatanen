<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI12TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI12TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI12TopicsSectionFactory::new();
    }

    protected $table = "topi12_topics_sections";
    protected $fillable = [
        'title', 'subtitle', 'text', 'active', 'sorting',
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
