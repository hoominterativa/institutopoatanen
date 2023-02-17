<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI01TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI01TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI01TopicsSectionFactory::new();
    }

    protected $table = "topi01_topics_sections";
    protected $fillable = ['title','subtitle','description','active', 'path_image_background', 'background_color'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
