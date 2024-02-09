<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI08TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI08TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI08TopicsSectionFactory::new();
    }

    protected $table = "topi08_topics_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'title_button', 'link_button', 'target_link_button', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
