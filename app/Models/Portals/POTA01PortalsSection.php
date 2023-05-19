<?php

namespace App\Models\Portals;

use Database\Factories\Portals\POTA01PortalsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POTA01PortalsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return POTA01PortalsSectionFactory::new();
    }

    protected $table = "pota01_portals_sections";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "active",
        "sorting",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
