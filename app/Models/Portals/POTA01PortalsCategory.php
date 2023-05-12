<?php

namespace App\Models\Portals;

use Database\Factories\Portals\POTA01PortalsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POTA01PortalsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return POTA01PortalsCategoryFactory::new();
    }

    protected $table = "pota01_portals_categories";
    protected $fillable = [
        "title",
        "slug",
        "active",
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

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('pota01_portals')->whereColumn('pota01_portals.category_id', 'pota01_portals_categories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('pota01_portals')->whereColumn('pota01_portals.category_id', 'pota01_portals_categories.id');
        });
    }
}
