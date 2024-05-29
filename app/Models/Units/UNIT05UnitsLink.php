<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsLinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05UnitsLink extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsLinkFactory::new();
    }

    protected $table = "unit05_units_links";
    protected $fillable = ['unit_id', 'title', 'link', 'target_link', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
