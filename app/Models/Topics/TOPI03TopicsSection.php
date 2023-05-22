<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI03TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI03TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI03TopicsSectionFactory::new();
    }

    protected $table = "topi03_topics_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
