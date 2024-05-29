<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT05UnitsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT05UnitsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT05UnitsSectionFactory::new();
    }

    protected $table = "unit05_units_sections";
    protected $fillable = [
        //Section
        "title_section", "subtitle_section", "description_section", "path_image_section", "active_section",
        //Banner
        "title_banner", "subtitle_banner", "path_image_desktop_banner", "path_image_mobile_banner", "active_banner",
        //General
        "sorting"
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
