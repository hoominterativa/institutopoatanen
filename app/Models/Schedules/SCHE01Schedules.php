<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE01SchedulesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE01Schedules extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE01SchedulesFactory::new();
    }

    protected $table = "sche01_schedules";
    protected $fillable = ['title', 'subtitle', 'event_date', 'event_time', 'description', 'text', 'information', 'title_button', 'link_button', 'target_link_button','path_image_sub', 'path_image_hours', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
