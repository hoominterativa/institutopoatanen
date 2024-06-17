<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI13TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI13TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI13TopicsSectionFactory::new();
    }

    protected $table = "topi13_topics_sections";
    protected $fillable = ['title', 'subtitle', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
