<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA02ContentPagesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA02ContentPagesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA02ContentPagesTopicFactory::new();
    }

    protected $table = "copa02_contentpages_topics";
    protected $fillable = ['title', 'subtitle', 'description', 'path_image_box', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
