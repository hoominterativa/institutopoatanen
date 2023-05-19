<?php

namespace App\Models\Portals;

use Database\Factories\Portals\POTA01PortalsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POTA01Portals extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return POTA01PortalsFactory::new();
    }

    protected $table = "pota01_portals";
    protected $fillable = [
        "category_id",
        "title",
        "slug",
        "publishing",
        "description",
        "text",
        "path_image_thumbnail",
        "path_image",
        "active",
        "featured_home",
        "view_section_video",
        "featured_page",
        "sorting",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeaturedPage($query)
    {
        return $query->where('featured_page', 1);
    }

    public function scopeFeaturedHome($query)
    {
        return $query->where('featured_home', 1);
    }

    public function scopeViewSectionVideo($query)
    {
        return $query->where('view_section_video', 1);
    }

    public function category()
    {
        return $this->belongsTo(POTA01PortalsCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->hasMany(POTA01PortalsTagAndPortal::class, 'blog_id', 'id')->with('tag')->join('pota01_portals_tags', 'pota01_portals_tags.id', 'pota01_portals_tagandportals.tag_id')->orderBy('pota01_portals_tags.title');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
