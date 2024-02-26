<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA03ContentPagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA03ContentPages extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA03ContentPagesFactory::new();
    }

    protected $table = "copa03_contentpages";
    protected $fillable = [
        'slug', 'title_page', 'title_topic_section', 'subtitle_topic_section', 'title_video_section', 'subtitle_video_section',
        'path_image_banner_desktop', 'path_image_banner_mobile', 'background_color_banner', 'active', 'sorting',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function categories()
    {
        return $this->hasMany(COPA03ContentPagesCategory::class, 'contentPage_id')->exists()->active()->sorting();
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query) {
            $query->select('id')
                ->from('copa03_contentpages_categories')
                ->whereColumn('copa03_contentpages_categories.contentPage_id', 'copa03_contentpages.id');
        });
    }
}
