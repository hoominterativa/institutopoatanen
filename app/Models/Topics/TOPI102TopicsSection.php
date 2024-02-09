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

    protected $table = "topi102_topics_sections";
    protected $fillable = ['title', 'subtitle','active',];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
