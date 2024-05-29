<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05UnitsContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsContentFactory::new();
    }

    protected $table = "unit05_units_contents";
    protected $fillable = ["unit_id", "title", "subtitle", "text", "path_image", "active", "sorting"];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
