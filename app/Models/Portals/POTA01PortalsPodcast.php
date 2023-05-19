<?php

namespace App\Models\Portals;

use Database\Factories\Portals\POTA01PortalsPodcastFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POTA01PortalsPodcast extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return POTA01PortalsPodcastFactory::new();
    }

    protected $table = "pota01_portals_podcasts";
    protected $fillable = [
        "title",
        "duration",
        "publishing",
        "description",
        "path_image_thumbnail",
        "path_archive",
        "embed",
        "featured_home",
        "active",
        "sorting",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeFeaturedHome($query)
    {
        return $query->where('featured_home', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
