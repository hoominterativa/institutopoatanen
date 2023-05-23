<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI10TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI10TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI10TopicsSectionFactory::new();
    }

    protected $table = "topi10_topics_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
