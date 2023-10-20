<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE02SchedulesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE02SchedulesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE02SchedulesSectionFactory::new();
    }

    protected $table = "sche02_schedules_sections";
    protected $fillable = [
        'title_section', 'subtitle_section', 'description_section', 'path_image_section', 'path_image_desktop_section', 'path_image_mobile_section', 'background_color_section',
        'title_banner', 'subtitle_banner', 'path_image_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner'
    ];

}
