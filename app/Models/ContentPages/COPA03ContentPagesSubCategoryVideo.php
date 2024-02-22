<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA03ContentPagesSubCategoryVideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA03ContentPagesSubCategoryVideo extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA03ContentPagesSubCategoryVideoFactory::new();
    }

    protected $table = "copa03_contentpages_subcategoryvideos";
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



    public function scopeExists($query)
    {
        return $query->whereExists(function($query) {
            $query->select('id')->from('copa03_contentpages_videos')->whereColumn('copa03_contentpages_videos.subvideo_id', 'copa03_contentpages_subcategoryvideos.id');
        });
    }
}
