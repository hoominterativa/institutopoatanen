<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE01SchedulesBannerShowFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE01SchedulesBannerShow extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE01SchedulesBannerShowFactory::new();
    }

    protected $table = "sche01_schedules_bannershows";
    protected $fillable = ['schedule_id','title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function schedule()
    {
        return $this->belongsTo(SCHE01Schedules::class, 'schedule_id');
    }
}
