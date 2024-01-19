<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT01UnitsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01UnitsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsSectionFactory::new();
    }

    protected $table = "unit01_units_sections";
    protected $fillable = [
        'title_section', 'subtitle_section', 'active_section',
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner'
    ];

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
