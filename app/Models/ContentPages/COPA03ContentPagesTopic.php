<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA03ContentPagesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA03ContentPagesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA03ContentPagesTopicFactory::new();
    }

    protected $table = "copa03_contentpages_topics";
    protected $fillable = ['subtopic_id', 'title', 'description', 'title_button', 'link_button', 'path_archive', 'path_image', 'path_image_icon', 'active', 'sorting',];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function subcategoryTopic()
    {
        return $this->belongsTo(COPA03ContentPagesSubCategoryTopic::class, 'subtopic_id');
    }
}
