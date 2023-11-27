<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA01ContentPagesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA01ContentPagesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA01ContentPagesTopicFactory::new();
    }

    protected $table = "copa01_contentpages_topics";
    protected $fillable = ['title', 'description', 'path_image', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
