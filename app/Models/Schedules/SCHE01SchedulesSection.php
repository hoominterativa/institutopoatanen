<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE01SchedulesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE01SchedulesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE01SchedulesSectionFactory::new();
    }

    protected $table = "sche01_schedules_sections";
    protected $fillable = [
        //Home Page
        'title', 'subtitle', 'active',
        //Section
        'title_section', 'subtitle_section', 'active_section',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop', 'path_image_mobile', 'active_banner',
        //General
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
