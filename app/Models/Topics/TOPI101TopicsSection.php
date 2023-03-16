<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI101TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI101TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI101TopicsSectionFactory::new();
    }

    protected $table = "topi101_topics_sections";
    protected $fillable = [
        'title', 'subtitle', 'background_color', 'path_image_desktop', 'path_image_mobile', 'active'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
