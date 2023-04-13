<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA02ContentPagesSectionTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA02ContentPagesSectionTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA02ContentPagesSectionTopicFactory::new();
    }

    protected $table = "copa02_contentpages_sectiontopics";
    protected $fillable = ['title', 'subtitle', 'description', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
