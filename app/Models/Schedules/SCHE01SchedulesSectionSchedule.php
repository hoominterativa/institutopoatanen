<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE01SchedulesSectionScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE01SchedulesSectionSchedule extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE01SchedulesSectionScheduleFactory::new();
    }

    protected $table = "sche01_schedules_sectionschedules";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
