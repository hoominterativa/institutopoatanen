<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA03ContentPagesSubCategoryTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA03ContentPagesSubCategoryTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA03ContentPagesSubCategoryTopicFactory::new();
    }

    protected $table = "copa03_contentpages_subcategorytopics";
    protected $fillable = ['category_id', 'slug', 'title', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(COPA03ContentPagesCategory::class, 'category_id');
    }

    public function topics()
    {
        return $this->hasMany(COPA03ContentPagesTopic::class, 'subtopic_id')->active()->sorting();
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query) {
            $query->select('id')->from('copa03_contentpages_topics')->whereColumn('copa03_contentpages_topics.subtopic_id', 'copa03_contentpages_subcategorytopics.id');
        });
    }
}
