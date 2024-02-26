<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA03ContentPagesVideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA03ContentPagesVideo extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA03ContentPagesVideoFactory::new();
    }

    protected $table = "copa03_contentpages_videos";
    protected $fillable = ['subvideo_id' ,'title' ,'link' ,'path_archive' ,'path_image' ,'active' ,'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function subcategory()
    {
        return $this->belongsTo(COPA03ContentPagesSubCategoryVideo::class, 'subvideo_id');
    }
}
