<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI10V1TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI10V1TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI10V1TopicsSectionFactory::new();
    }

    protected $table = "topi10v1_topics_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
