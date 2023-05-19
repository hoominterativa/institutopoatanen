<?php

namespace App\Models\Portals;

use Database\Factories\Portals\POTA01PortalsAdvertsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POTA01PortalsAdverts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return POTA01PortalsAdvertsFactory::new();
    }

    protected $table = "pota01_portals_adverts";
    protected $fillable = [
        "category_id",
        "blog_id",
        "path_image",
        "adsense",
        "link",
        "link_target",
        "position",
        "date_start",
        "date_end",
        "active",
        "sorting",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeBetween($query)
    {
        return $query->whereRaw('NOW() BETWEEN date_start AND date_end');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->hasOne(POTA01PortalsCategory::class, 'id', 'category_id');
    }

    public function categories()
    {
        return $this->hasMany(POTA01PortalsCategory::class, 'id', 'category_id');
    }

    public function portals()
    {
        return $this->hasMany(POTA01Portals::class, 'id', 'blog_id');
    }
}
